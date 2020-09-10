<?php

use Illuminate\Database\Seeder;

class MatrixQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\MatrixQuestion::class, 2)->create(['question_group_id' => 1])
            ->each(function ($question) {
                factory(\App\MatrixQuestionElement::class, 2)
                    ->create(['matrix_question_id' => $question->id]);
                factory(\App\QuestionOption::class, 3)
                    ->create([
                        'question_id' => $question->id,
                        'question_type' => \App\MatrixQuestion::class
                    ]);
            });

        factory(\App\MatrixQuestion::class, 2)->create(['question_group_id' => 3])
            ->each(function ($question) {
                factory(\App\MatrixQuestionElement::class, 2)
                    ->create(['matrix_question_id' => $question->id]);
                factory(\App\QuestionOption::class, 3)
                    ->create([
                        'question_id' => $question->id,
                        'question_type' => \App\MatrixQuestion::class
                    ]);
            });
    }
}
