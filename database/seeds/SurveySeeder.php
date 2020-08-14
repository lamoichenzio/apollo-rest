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
        factory(App\Survey::class,2)->make()->each(function ($survey){
            $survey-> user_id = App\User::find(2)->id;
            $survey-> save();
        });

    }
}
