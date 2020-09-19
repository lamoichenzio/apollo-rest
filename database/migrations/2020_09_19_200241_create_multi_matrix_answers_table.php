<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiMatrixAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_matrix_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matrix_question_id')
                ->references('id')
                ->on('matrix_questions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('survey_answer_id')
                ->references('id')
                ->on('survey_answers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('multi_matrix_answers');
    }
}
