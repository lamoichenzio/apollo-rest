<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrixQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrix_questions', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->integer('position');
            $table->boolean('mandatory')->default(false);
            $table->binary('icon')->nullable();
            $table->enum('type', \App\Enums\MatrixQuestionTypes::types());
            $table->foreignId('question_group_id')
                ->references('id')
                ->on('question_groups')
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
        Schema::dropIfExists('matrix_questions');
    }
}
