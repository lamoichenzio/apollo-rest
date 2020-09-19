<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiMatrixAnswerPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_matrix_answer_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matrix_answer_id')
                ->references('id')
                ->on('multi_matrix_answers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('element_id')
                ->references('id')
                ->on('matrix_question_elements')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('multi_answer_id')
                ->references('id')
                ->on('multi_answers')
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
        Schema::dropIfExists('multi_matrix_answer_pairs');
    }
}
