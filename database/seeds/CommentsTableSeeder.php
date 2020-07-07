<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        \App\Models\Comment::truncate();

        $faker = \Faker\Factory::create();
        for ($i = 1; $i < 3; $i++) {
            $id = $i;
            $this->createComment($id, $id);
            for ($k = 1; $k < 3; $k++) {
                $path = $id . \App\Models\Comment::PATCH_SEPARATOR . $k;
                $child_id = $id + $k * 2 + 20;
                $this->createComment($child_id, $path, $id);
            }
        }
        $this->createComment(300, $path . \App\Models\Comment::PATCH_SEPARATOR . '1', $child_id);
    }

    private function createComment($id, $path = null, $parent_id = null){
        \App\Models\Comment::create([
            'id' => $id,
            'user_id' => 1,
            'post_id' => 1,
            'parent_id' => $parent_id,
            'status' => 1,
            'path' => $path,
            'body' => 'Comment #' . $id,
            "created_at" => "2020-07-07T08:23:03.000000Z",
            "updated_at" => "2020-07-07T08:23:03.000000Z",
        ]);
    }
}
