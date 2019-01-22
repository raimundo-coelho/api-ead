<?php

use IDEALE\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class, 1)->create([
            'user_id' => 1,
            'category_id' => 1,
            'name'  => 'Curso de Auto Maquiagem',
            'price'  => 49.90,
            'status'  => 1,
            'image'  => '',
            'banner'  => '',
        ]);
    }
}
