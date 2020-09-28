<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrixAnswerPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrix_answer_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('single_matrix_answer_id')
                ->references('id')
                ->on('single_matrix_answers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('element_id')
                ->references('id')
                ->on('matrix_question_elements')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->text('answer');
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
        Schema::dropIfExists('matrix_answer_pairs');
    }
}
