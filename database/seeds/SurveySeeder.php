<?php

use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Survey::class, 2)->create();
        factory(\App\Survey::class)->create(['user_id' => 2]);

    }
}
