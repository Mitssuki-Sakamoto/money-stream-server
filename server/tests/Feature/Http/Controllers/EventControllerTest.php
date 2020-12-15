<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\UserEventRelation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{

    public function testStore()
    {
        $data = [ # 登録用のデータ
            'name' => 'hogehoge',
            'start_date' => '2020-01-01',
            'description' => 'ryokou hogehoge',
        ];

        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ZVgAC0C25ISrsoLN0FX7LrO78pcSI2ZJ',
        ])->post(route('event.store'), $data);

        // レスポンス検証
        $response->assertOk() # ステータスコードが 200
        ->assertJsonFragment($data);

    }

    public function testUpdate()
    {
        $data = [ # 登録用のデータ
            'name' => 'hogehoge',
            'start_date' => '2020-01-01',
            'description' => 'ryokou hogehoge',
        ];

        // `users` テーブルにデータを作成
        $event =Event::create($data);
        $user_event = UserEventRelation::create([
            'event_id'=>$event->id,
            'user_id' => 1,
            'manager' => true
        ]);
        $update_data = [ # 登録用のデータ
            'name' => 'hogehoge1',
            'start_date' => '2020-01-02',
            'description' => 'ryokou hogehoge1',
        ];
        $event->save();
        $user_event->save();
        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ZVgAC0C25ISrsoLN0FX7LrO78pcSI2ZJ',
        ])->put(route('event.update', [$event->id]), $update_data);

        // レスポンス検証
        $response->assertOk() # ステータスコードが 200
        ->assertJsonFragment($update_data);
    }
}
