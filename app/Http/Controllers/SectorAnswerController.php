<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectorAnswer\CreateSectorAnswerRequest;
use App\Models\Sector;
use App\Models\SectorAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SectorAnswerController extends Controller
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
    public function create(string $analysisId, string $sectorId, CreateSectorAnswerRequest $request)
    {
        $sector = Sector::find($sectorId);

        if (!$sector) {
            throw new HttpException(404, "Sector not found.");
        }

        $enterprise = $sector->enterprise()->first();

        $analysis = $enterprise->analyses()->get()->filter(function ($item) use ($analysisId) {
            return $item->id === (int) $analysisId;
        })->first();

        if (!$analysis) {
            throw new HttpException(404, "Analysis not found");
        }

        $allowedUser = $enterprise->users()->get()->filter(function ($item) {
            return $item->id === Auth::id();
        })->first();

        if (!$allowedUser) {
            throw new HttpException(401, "Unauthorized");
        }

        $alreadyAnswered = SectorAnswer::where('analysis_id', $analysis->id)->where('sector_id', $sector->id)->first();

        if ($alreadyAnswered) {
            throw new HttpException(403, "Sector answer already registered for this analysis");
        }

        $answerAttributes = array('analysis_id' => $analysis->id, 'sector_id' => $sector->id, 'gci' => $request->gci, 'gin' => $request->gin, 'answers' => json_encode($request->answers));
        SectorAnswer::create($answerAttributes);

        return response('Survey Answer created successfully', 201);
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
     * @param  \App\Models\SectorAnswer  $sectorAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(SectorAnswer $sectorAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SectorAnswer  $sectorAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(SectorAnswer $sectorAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectorAnswer  $sectorAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectorAnswer $sectorAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectorAnswer  $sectorAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectorAnswer $sectorAnswer)
    {
        //
    }
}
