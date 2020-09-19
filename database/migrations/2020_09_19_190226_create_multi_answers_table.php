<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multi_question_id')
                ->references('id')
                ->on('multi_questions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('survey_answer_id')
                ->references('id')
                ->on('survey_answers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_answers');
    }
}
