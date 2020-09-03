<?php

use Illuminate\Database\Seeder;

class InputQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\InputQuestion::class, 2)->create(['question_group_id' => 1]);
        factory(\App\InputQuestion::class, 2)->create(['question_group_id' => 2]);
    }
}
