<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_questions', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->integer('position');
            $table->boolean('mandatory')->default(false);
            $table->binary('icon')->nullable();
            $table->enum('type', \App\Enums\MultiQuestionTypes::types());
            $table->boolean('other')->default(false);
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
        Schema::dropIfExists('multi_questions');
    }
}
