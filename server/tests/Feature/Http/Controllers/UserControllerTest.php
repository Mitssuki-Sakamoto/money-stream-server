<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [ # 登録用のデータ
            'name' => 'hogehoge',
        ];

        // POST リクエスト
        $response = $this->post(route('user.store'), $data);
        // レスポンス検証
        $response->assertOk();
    }

    public function testUpdate()
    {
        $data = [ # 登録用のデータ
            'name' => 'userhoge1',
        ];

        // POST リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer GSyks22FO4f2Jm3phVcwrdVCMSdMeOMy',
        ])->put(route('user.update', [4]), $data);
        // レスポンス検証
        $response->assertOk();
    }

    public function testFriends()
    {
        //GET リクエスト
        $response = $this->withHeaders([
            'Authorization' => 'Bearer FHGSyYcxHZf3gjq7oDSYJOS2evsiidOo',
        ])->get(route('user.friends'));
        // レスポンス検証
        $response->assertOk();
    }
}
