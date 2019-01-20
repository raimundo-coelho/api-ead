<?php

use IDEALE\Models\Reply;
use Illuminate\Database\Seeder;

class RepliesTableSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Reply::class, 12)->create(['user_id' => 1, 'thread_id' => rand(1, 5), 'body' => 'Body do reply - resposta do topico   how de bola']);
        factory(Reply::class, 12)->create(['user_id' => 2, 'thread_id' => rand(6, 8), 'body' => 'Body do reply - resposta do topico   how de bola']);
        factory(Reply::class, 12)->create(['user_id' => 3, 'thread_id' => rand(9, 13), 'body' => 'Body do reply - resposta do topico   how de bola']);


    }
}
