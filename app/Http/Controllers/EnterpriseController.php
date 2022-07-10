<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Sector\EditEnterpriseRequest;
use App\Models\Enterprise;
use App\Models\EnterpriseUser;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enterprises = User::find(Auth::id())->enterprises()->get();

        $payload = [];

        foreach ($enterprises as $enterprise) {
            array_push($payload, (object) ['id' => $enterprise->id, 'name' => $enterprise->name]);
        }

        return response($payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateEnterpriseRequest $request)
    {
        $alreadyExists = User::find(Auth::id())->enterprises()->where('name', $request->name)->first();

        if ($alreadyExists) {
            throw new HttpException(409, 'An enterprise with this name already exists');
        }

        $enterpriseAttributes = array('name' => $request->name);
        $enterprise = Enterprise::create($enterpriseAttributes);

        $enterpriseUserAttributes = array('user_id' => Auth::id(), 'enterprise_id' => $enterprise->id);
        EnterpriseUser::create($enterpriseUserAttributes);

        return response('Enterprise created successfully', 201);
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
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function show(string $enterpriseId)
    {
        $enterprise = User::find(Auth::id())->enterprises()->find($enterpriseId);

        if ($enterprise) return response(['id' => $enterprise->id, 'name' => $enterprise->name]);

        throw new HttpException(404, 'Enterprise not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function edit(string $enterpriseId, EditEnterpriseRequest $request)
    {
        $enterprise = User::find(Auth::id())->enterprises()->where("enterprise_id", $enterpriseId)->first();

        if (!$enterprise) {
            throw new HttpException(401, 'Enterprise not found');
        }

        $enterprise->name = $request->name;
        $enterprise->save();

        return response(['success' => true, 'message' => 'Enterprise edited successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enterprise $enterprise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $enterpriseId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $enterpriseId)
    {
        $hasEnterprise = User::find(Auth::id())->enterprises()->find($enterpriseId)->first();

        if(!$hasEnterprise){             
            throw new HttpException(404, 'No enterprise has been found with this id');
        }

        $hasEnterprise->sectors()->delete();

        $hasEnterprise->users()->delete();

        $hasEnterprise->delete();

        return response('Enterprise deleted successfully', 200);
    }
}
