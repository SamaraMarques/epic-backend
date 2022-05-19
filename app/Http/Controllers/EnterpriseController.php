<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
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
    public function show(Enterprise $enterprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Enterprise $enterprise)
    {
        //
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
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprise)
    {
        //
    }
}
