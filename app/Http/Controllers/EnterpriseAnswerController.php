<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnterpriseAnswer\CreateEnterpriseAnswerRequest;
use App\Models\EnterpriseAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnterpriseAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $analysisId, string $enterpriseId, CreateEnterpriseAnswerRequest $request)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $analysis = $enterprise->analyses()->get()->filter(function ($item) use ($analysisId) {
            return $item->id === (int) $analysisId;
        })->first();

        if (!$analysis) {
            throw new HttpException(404, "Analysis not found");
        }

        $alreadyAnswered = EnterpriseAnswer::where('analysis_id', $analysis->id)->where('enterprise_id', $enterprise->id)->first();

        if ($alreadyAnswered) {
            throw new HttpException(403, "Enterprise answer already registered for this analysis");
        }

        $answerAttributes = array('analysis_id' => $analysis->id, 'enterprise_id' => $enterprise->id, 'answers' => json_encode($request->answers));
        EnterpriseAnswer::create($answerAttributes);

        return response('Enterprise Answer created successfully', 201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnterpriseAnswer  $enterpriseAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(EnterpriseAnswer $enterpriseAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnterpriseAnswer  $enterpriseAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(EnterpriseAnswer $enterpriseAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EnterpriseAnswer  $enterpriseAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnterpriseAnswer $enterpriseAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnterpriseAnswer  $enterpriseAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnterpriseAnswer $enterpriseAnswer)
    {
        //
    }
}
