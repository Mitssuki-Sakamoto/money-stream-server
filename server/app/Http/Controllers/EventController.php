<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        $user_event_relation->manager = True;
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
        $user_event_relation = UserEventRelation::where('event_id', $event_id)->first();
        if ($user_event_relation->user_id != Auth::id()){
            throw new BadRequestException('This event is not yours.');
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

}

