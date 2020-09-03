<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_questions', function (Blueprint $table) {

            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->boolean('mandatory')->default(false);
            $table->binary('icon')->nullable();
            $table->enum('type', \App\Enums\InputQuestionType::types());
            $table->timestamps();

            $table->foreignId('question_group_id')
                ->references('id')
                ->on('question_groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_questions');
    }
}
