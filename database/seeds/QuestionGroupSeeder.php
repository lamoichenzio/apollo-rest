<?php

use Illuminate\Database\Seeder;

class QuestionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\QuestionGroup::class, 2)->create(['survey_id' => 1]);
        factory(\App\QuestionGroup::class, 2)->create(['survey_id' => 2]);
    }
}
