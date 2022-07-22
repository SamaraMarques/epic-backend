<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sector\CreateSectorRequest;
use App\Http\Requests\Sector\EditSectorRequest;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource by enterprise.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByEnterprise(string $enterpriseId)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $sectors = $enterprise->sectors()->get();

        $payload = [];

        foreach ($sectors as $sector) {
            array_push($payload, (object) ['id' => $sector->id, 'enterprise_id' => $sector->enterprise_id, 'name' => $sector->name]);
        }

        return response($payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForEnterprise(string $enterpriseId, CreateSectorRequest $request)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where('enterprise_id', $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(404, 'Enterprise not found');
        }

        $alreadyExists = $enterprise->sectors()->where('name', $request->name)->first();;

        if ($alreadyExists) {
            throw new HttpException(409, 'A sector with this name already exists');
        }

        $sectorAttributes = array('name' => $request->name, 'enterprise_id' => $enterpriseId);
        Sector::create($sectorAttributes);

        return response(['success' => true, 'message' => 'Sector created successfully'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $sectorId
     * @return \Illuminate\Http\Response
     */
    public function edit(string $enterpriseId, string $sectorId, EditSectorRequest $request)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where("enterprise_id", $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(401, 'Enterprise not found');
        }

        $sector = Sector::where('id', $sectorId)->where('enterprise_id', $enterpriseId)->first();

        if (!$sector) {
            throw new HttpException(404, 'Sector not found');
        }

        $sector->name = $request->name;
        $sector->save();

        return response(['success' => true, 'message' => 'Sector edited successfully'], 200);
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
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(string $sectorId)
    {
        $enterprises = User::find(Auth::id())->enterprises()->get();

        foreach ($enterprises as $enterprise){
            $sector = $enterprise->sectors()->where('id', $sectorId)->first();

            if ($sector) return response(['id' => $sector->id, 'enterprise_id' => $sector->enterprise_id, 'name' => $sector->name]);
        }

        throw new HttpException(404, 'Sector not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sector $sector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $sectorId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $sectorId)
    {
        $enterprises = User::find(Auth::id())->enterprises()->get();

        foreach ($enterprises as $enterprise){
            $sector = $enterprise->sectors()->where('id', $sectorId)->first();

            if ($sector) {
                $sector->delete();
                return response(['success' => true, 'message' => 'Sector deleted successfully'], 200);
            }
        }

        throw new HttpException(404, 'Sector not found');
    }
}
