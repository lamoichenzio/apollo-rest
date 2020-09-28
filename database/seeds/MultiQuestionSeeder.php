<?php

use Illuminate\Database\Seeder;

class MultiQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\MultiQuestion::class, 2)->create(['question_group_id' => 1])
            ->each(function ($question) {
                factory(\App\QuestionOption::class, 3)->create([
                    'question_id' => $question->id,
                    'question_type' => \App\MultiQuestion::class
                ]);
            });

        factory(\App\MultiQuestion::class, 2)->create(['question_group_id' => 3])
            ->each(function ($question) {
                factory(\App\QuestionOption::class, 3)->create([
                    'question_id' => $question->id,
                    'question_type' => \App\MultiQuestion::class
                ]);
            });
    }
}
