<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' =>' mimes:jpeg,bmp,png',
        ]);
        //
        $user = new User();
        $user->invent_code = User::generateInventCode();
        $user->api_key = User::generateApiKey();
        try
        {
            if ($request->has('thumbnail'))
            {
                $thumbnail_path = $request->file('thumbnail')->store('images');
                $user->thumbnail = Storage::url($thumbnail_path);
            }
        }
        catch (\Exception $e)
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
        $request->validate([
            'name' => 'string|max:255',
            'thumbnail' =>' mimes:jpeg,bmp,png',
        ]);
        $user = User::find($id);
        if ($id != Auth::id()){
            throw new AuthenticationException('This user has not authentication.');
        }
        try
        {
            if ($request->has('thumbnail'))
            {
                $thumbnail_path = $request->file('thumbnail')->store('images');
                $user->thumbnail = Storage::url($thumbnail_path);
            }
        }
        catch (\Exception $e)
        {
            return response($e->getMessage(), 500);
        }

        if ($request->has('thumbnail')){
            $user->name = $request->name;
        }
        $user->save();
        return response($user);
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

    public function friends($id)
    {
        //
    }
}
