<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
            if ($user === null) {
                $user = new User;
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
          
                if($user -> save()) {
                    return new UserResource($user);
                }
        } else {
            $dataObj = new \stdClass();
            $dataObj->errorMessage = 'User with that email already exists!';
            return json_encode($dataObj);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
