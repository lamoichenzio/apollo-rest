<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SurveySeeder::class);
        $this->call(QuestionGroupSeeder::class);
        $this->call(InputQuestionSeeder::class);
        $this->call(MultiQuestionSeeder::class);
        $this->call(MatrixQuestionSeeder::class);
        $this->call(InvitationPoolSeeder::class);
//        $this->call(SurveyAnswerSeeder::class);
    }
}
