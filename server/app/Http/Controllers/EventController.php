<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\UserEventRelation;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class EventController extends Controller
{
    //
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
                'start_date' => 'required|date:Y-m-d',
                'end_date' => 'date:Y-m-d',
                'description' => 'string',
            ]);
        $event = new Event();
        $user_event_relation = new UserEventRelation();
        $event->name = $request->input('name');
        $event->start_date = $request->input('start_date');
        if ($request->has('thumbnail'))
            // ここにアップロード処理
            $event->thumbnail = $request->input('thumbnail');
        if ($request->has('end_date'))
            $event->end_date = $request->input('end_date');
        if ($request->has('description'))
            $event->description = $request->input('description');
        $event->save();
        $user_event_relation->user_id = Auth::id();
        $user_event_relation->event_id = $event->id;
        $user_event_relation->status = UserEventRelation::MANAGER;
        $user_event_relation->save();
        return response($event);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'thumbnail' => 'mimes:jpeg,bmp,png',
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'description' => 'string',
        ]);
        $event = Event::find($event_id);
        $user_id = Auth::id();
        $user_event_relation = UserEventRelation::where('event_id', $event_id)->where('user_id', $user_id)->first();
        if (empty($user_event_relation)){
            throw new BadRequestException('This event is not yours.');
        }
        if ($user_event_relation->status != UserEventRelation::MANAGER){
            throw new BadRequestException('You don\'t have authority to edit this event.');
        }
        if ($request->has('name'))
            $event->name = $request->input('name');
        if ($request->has('start_date'))
            $event->start_date = $request->input('start_date');
        if ($request->has('thumbnail'))
            // ここにアップロード処理
            $event->thumbnail = $request->input('thumbnail');
        if ($request->has('end_date'))
            $event->end_date = $request->input('end_date');
        if ($request->has('description'))
            $event->description = $request->input('description');
        $event->save();
        return response($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($event_id)
    {
        UserEventRelation::where('event_id', $event_id)->where('user_id', Auth::id())->delete();
        Event::destroy($event_id);
        return $event_id;
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
        return Event::find($id);
    }

    public function list()
    {
        $event_ids = UserEventRelation::select('event_id')->where('user_id', Auth::id())->get();
        $events = Event::find($event_ids);
        return response($events);
    }

    public function users($id)
    {
        //
        $user_ids = UserEventRelation::select('user_id')->where('event_id', $id)->get();
        $users = User::find($user_ids);
        return response($users);
    }

    public function user_invent(Request $request, $id)
    {
        $request->validate([
            'users_ids' => 'required|array',
            'users_ids.*' => 'required|exists:users,id'
        ]);
        $owner_user_event_relation = UserEventRelation::where('event_id', $id)->where('user_id', Auth::id())->first();
        if ($owner_user_event_relation->status != UserEventRelation::MANAGER){
            throw new AuthenticationException('This user has not authentication.');
        }
        $users_ids = $request->input('users_ids');
        foreach ($users_ids as $user_id) {
            $user_event_relation = new UserEventRelation();
            $user_event_relation->user_id = $user_id;
            $user_event_relation->event_id = $id;
            $user_event_relation->status = UserEventRelation::INVENTED;
            $user_event_relation->save();
        }
        return response($users_ids);
    }

    public function accept_invent(Request $request, $id)
    {
        $request->validate([
            'accept' => 'required|boolean']);
        $accept = $request->input('accept');
        $user_event_relation = UserEventRelation::where('event_id', $id)->where('user_id', Auth::id())->first();
        if ($user_event_relation->status != UserEventRelation::INVENTED){
            throw new BadRequestException('This user is not invented.');
        }
        if ($accept){
            $user_event_relation->status = UserEventRelation::NORMAL;
        }else{
            UserEventRelation::where('event_id', $id)->where('user_id', Auth::id())->delete();
        }
        return response($accept);
    }

    public function delete_user(Request $request, $event_id, $user_id)
    {
        $owner_user_event_relation = UserEventRelation::where('event_id', $event_id)->where('user_id', Auth::id())->first();
        if ($owner_user_event_relation->status != UserEventRelation::MANAGER){
            throw new BadRequestException('This user is not invented.');
        }
        UserEventRelation::where('event_id', $event_id)->where('user_id', $user_id)->delete();
        return response($user_id);
    }

}

