<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseTransactions;
    public function testIndexTree()
    {
        $this->json('GET', '/api/v1/comments/1')
            ->assertStatus(200)
            ->assertJson(['data' => array(0 => array('id' => 1, 'post_id' => 1, 'user_id' => 1, 'path' => '1', 'status' => 1, 'body' => 'Comment #1', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => NULL, 'children' => array('1.1' => array('id' => 23, 'post_id' => 1, 'user_id' => 1, 'path' => '1.1', 'status' => 1, 'body' => 'Comment #23', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => 1, 'children' => array(),), '1.2' => array('id' => 25, 'post_id' => 1, 'user_id' => 1, 'path' => '1.2', 'status' => 1, 'body' => 'Comment #25', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => 1, 'children' => array(),),),), 1 => array('id' => 2, 'post_id' => 1, 'user_id' => 1, 'path' => '2', 'status' => 1, 'body' => 'Comment #2', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => NULL, 'children' => array('2.1' => array('id' => 24, 'post_id' => 1, 'user_id' => 1, 'path' => '2.1', 'status' => 1, 'body' => 'Comment #24', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => 2, 'children' => array(),), '2.2' => array('id' => 26, 'post_id' => 1, 'user_id' => 1, 'path' => '2.2', 'status' => 1, 'body' => 'Comment #26', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => 2, 'children' => array('2.2.1' => array('id' => 300, 'post_id' => 1, 'user_id' => 1, 'path' => '2.2.1', 'status' => 1, 'body' => 'Comment #300', 'created_at' => '2020-07-07T08:23:03.000000Z', 'updated_at' => '2020-07-07T08:23:03.000000Z', 'parent_id' => 26, 'children' => array(),),),),),),)]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->json('PUT', '/api/v1/comments/1', ['body' => 'test comment'])
            ->assertStatus(202);

        $this->assertDatabaseHas('comments', ['body' => 'test comment']);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRootCreate()
    {
        $this->json('POST', '/api/v1/comments/1', ['body' => 'Create new root comment', 'user_id' => 1])
            ->assertStatus(201);

        $this->assertDatabaseHas('comments', ['body' => 'Create new root comment', 'parent_id' => null]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testChildCreate()
    {
        $this->json('POST', '/api/v1/comments/1', ['body' => 'Create new child comment', 'parent_id' => 1, 'user_id' => 1])
            ->assertStatus(201);

        $this->assertDatabaseHas('comments', ['body' => 'Create new child comment', 'parent_id' => 1]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDelete()
    {
        $this->json('DELETE', '/api/v1/comments/1')
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', ['id' => 1, 'status' => -1]);

    }
}
