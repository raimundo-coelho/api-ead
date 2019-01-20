<?php

use Illuminate\Database\Seeder;

class TreadsTableSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\IDEALE\Models\Thread::class, 5)->create(['user_id' => 1]);
        factory(\IDEALE\Models\Thread::class, 3)->create(['user_id' => 2]);
        factory(\IDEALE\Models\Thread::class, 4)->create(['user_id' => 3]);
    }
}
