<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    private function generateInventCode(int $size = 20)
    {
        return Str::random($size);
    }

    private function generateApiKey(int $size = 40)
    {
        return Str::random($size);
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
        $user = new User;
        $user->invent_code = $this->generateInventCode();
        $user->api_key = $this->generateApiKey();
        try
        {
            if ($request->has('thumbnail'))
            {
            $user->thumbnail = $request->file('thumbnail')->store('images');
            }
        }
        catch (Exception $e)
        {
            return response($e->getMessage(), 500);
        }
        $user->name = $request->name;
        $user->save();
        return response(["user" => $user, "api_key"=>$user->api_key]);
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
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
