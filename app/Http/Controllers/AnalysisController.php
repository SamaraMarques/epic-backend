<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\EnterpriseAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByEnterprise(string $enterpriseId)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $analyses = $enterprise->analyses()->get();

        $payload = [];

        foreach ($analyses as $analysis) {
            array_push($payload, (object) ['id' => $analysis->id, 'enterprise_id' => $analysis->enterprise_id, 'created_at' => $analysis->created_at]);
        }

        return response($payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForEnterprise(string $enterpriseId)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $analysis = Analysis::create(array('enterprise_id' => $enterpriseId));

        return response(['success' => true, 'message' => 'Analysis created successfully', 'analysis_id' => $analysis->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Analysis  $analysis
     * @return \Illuminate\Http\Response
     */
    public function result(string $analysisId)
    {
        $analysis = Analysis::find($analysisId);

        if (!$analysis) {
            throw new HttpException(404, "Analysis not found");
        }

        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $analysis->enterprise_id)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $enterpriseAnswers = json_decode(EnterpriseAnswer::where('analysis_id', $analysisId)->first()->answers);

        $enterpriseSecurityIndex = $this->calculateEnterpriseSecurity($enterpriseAnswers->answers);

        $sectorAnswers = $analysis->sectorsAnswers->map(function ($sectorAnswer) {
            $answers = json_decode($sectorAnswer->answers);
            return ['name' => $sectorAnswer->sector->name, 'gin' => $sectorAnswer->gin, 'gci' => $sectorAnswer->gci, 'answers' => $answers->answers];
        })->toArray();
        $sectorsConformityIndex = $this->calculateSectorsConformity($sectorAnswers);

        return response([
            'enterprise' => ['name' => $enterprise->name, 'index' => $enterpriseSecurityIndex, 'answers' => $enterpriseAnswers->answers, 'id' => $enterprise->id],
            'sectors' => $sectorsConformityIndex,
            'created_at' => $analysis->created_at
        ], 200);
    }

    private function calculateEnterpriseSecurity(array $answers)
    {
        $applicableAnswers = count(array_filter($answers, function ($answer) {
            return $answer != 2;
        }));

        $affirmative = count(array_filter($answers, function ($answer) {
            return $answer == 1;
        }));
        return round($affirmative / $applicableAnswers, 2);
    }

    private function calculateSectorsConformity(array $sectorAnswers)
    {
        return array_map(function ($sectorAnswer) {
            $sectorCriticalityLevel = ($sectorAnswer['gci'] / 3) * ($sectorAnswer['gin'] / 3);

            $applicableAnswers = count(array_filter($sectorAnswer['answers'], function ($answer) {
                return $answer != 2;
            }));

            $negativeAnswers = count(array_filter($sectorAnswer['answers'], function ($answer) {
                return $answer == 0;
            }));

            $partialNCIndex = $negativeAnswers / $applicableAnswers;
            $finalNCIndex = $sectorCriticalityLevel * $partialNCIndex;

            return ['name' => $sectorAnswer['name'], 'gin' => $sectorAnswer['gin'], 'gci' => $sectorAnswer['gci'], 'answers' => $sectorAnswer['answers'], 'finalNCIndex' => round($finalNCIndex, 2)];
        }, $sectorAnswers);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $analysisId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $analysisId)
    {
        $analysis = Analysis::find($analysisId);

        if (!$analysis) {
            throw new HttpException(404, "Analysis not found");
        }

        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $analysis->enterprise_id)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        DB::beginTransaction();
        $analysis->enterpriseAnswers->delete();
        foreach ($analysis->sectorsAnswers as $sectorAnswer){
            $sectorAnswer->delete();
        }
        $analysis->delete();
        DB::commit();

        return response(['success' => true, 'message' => 'Analysis deleted successfully'], 200);
    }
}
