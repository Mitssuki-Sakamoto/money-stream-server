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
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
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
            'status' => UserEventRelation::MANAGER
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
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
        ])->put(route('event.update', [$event->id]), $update_data);

        // レスポンス検証
        $response->assertOk() # ステータスコードが 200
        ->assertJsonFragment($update_data);
    }

    public function testDestroy()
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
            'status' => UserEventRelation::MANAGER
        ]);
        $update_data = [ # 登録用のデータ
            'name' => 'hogehoge1',
            'start_date' => '2020-01-02',
            'description' => 'ryokou hogehoge1',
        ];
        $event->save();
        $user_event->save();
        $event_id = $event->id;
        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
        ])->delete(route('event.destroy', [$event->id]));

        // レスポンス検証
        $response->assertOk() # ステータスコードが 200
        ->assertJsonFragment([$event_id]);
    }

    public function testList()
    {
        $datas = [ # 登録用のデータ
            [
                'name' => 'hogehoge',
                'start_date' => '2020-01-01',
                'description' => 'ryokou hogehoge',
            ],
            [
                'name' => 'hogehoge1',
                'start_date' => '2020-01-02',
                'description' => 'ryokou hogehoge',
            ]
        ];

        // `users` テーブルにデータを作成
        $event1 =Event::create($datas[0]);
        $event2 =Event::create($datas[1]);
        $user_event = UserEventRelation::create([
            'event_id'=>$event1->id,
            'user_id' => 2,
            'status' => UserEventRelation::MANAGER
        ]);
        $user_event = UserEventRelation::create([
            'event_id'=>$event2->id,
            'user_id' => 2,
            'status' => UserEventRelation::MANAGER
        ]);

        $event1->save();
        $event2->save();
        $user_event->save();
        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer b0B4C2vvso6XBPjtPI50xY2bKjhKhS6y',
        ])->get(route('event.list'));

        // レスポンス検証
        $response->assertOk(); # ステータスコードが 200
    }

    public function testUsers()
    {
        $data = [ # 登録用のデータ
            'name' => 'hogehoge',
            'start_date' => '2020-01-01',
            'description' => 'ryokou hogehoge',
        ];

        // `users` テーブルにデータを作成
        $event =Event::create($data);
        $user_event1 = UserEventRelation::create([
            'event_id'=>$event->id,
            'user_id' => 1,
            'status' => UserEventRelation::MANAGER
        ]);

        $user_event2 = UserEventRelation::create([
            'event_id'=>$event->id,
            'user_id' => 2,
            'status' => UserEventRelation::NORMAL
        ]);

        $event->save();
        $user_event1->save();
        $user_event2->save();
        $event_id = $event->id;
        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
        ])->get(route('event.users', [$event->id]));

        // レスポンス検証
        $response->assertOk(); # ステータスコードが 200
    }

    public function testUserInvent()
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
            'status' => UserEventRelation::MANAGER
        ]);
        $invent_data = [ # 登録用のデータ
            'users_ids' => array(2,3)
        ];
        $event->save();
        $user_event->save();
        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
        ])->post(route('event.user_invent', [$event->id]), $invent_data);

        // レスポンス検証
        $response->assertOk(); # ステータスコードが 200
    }

    public function testAcceptInvent()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer b0B4C2vvso6XBPjtPI50xY2bKjhKhS6y',
        ])->post(route('event.accept_invent', [166]), ['accept'=>true]);

        // レスポンス検証
        $response->assertOk(); # ステータスコードが 200

        $response = $this->withHeaders([
            'Authorization' => 'Bearer WyciSJvPn8hA2ZXrsb43y1RALe3tdL2a',
        ])->post(route('event.accept_invent', [166]), ['accept'=>false]);

        // レスポンス検証
        $response->assertOk(); # ステータスコードが 200
    }
}
