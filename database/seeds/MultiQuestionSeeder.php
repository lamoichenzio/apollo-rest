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
        $question = factory(\App\MultiQuestion::class)->create(['question_group_id' => 1]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);


        $question = factory(\App\MultiQuestion::class)->create(['question_group_id' => 2]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);

        $question = factory(\App\MultiQuestion::class)->create(['question_group_id' => 2]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
        factory(\App\QuestionOption::class)->create(['question_id' => $question->id]);
    }
}
