<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToolTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCrudTool()
    {
        $create = $this->postJson('/api/v1/tool', [
            'name' => 'teste 1',
            'link' => 'https://google.com',
            "tags" => ["node", "php", "vuejs"]
        ]);

        $create->assertStatus(201);
        $tool = $create->decodeResponseJson();

        $getAll = $this->get('/api/v1/tool');

        $getAll->assertStatus(200);


        $delete = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('DELETE', '/api/v1/tool/'.$tool['id']);

        $delete->assertStatus(200);
    }

}
