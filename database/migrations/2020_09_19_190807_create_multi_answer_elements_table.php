<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiAnswerElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_answer_elements', function (Blueprint $table) {
            $table->id();
            $table->text('answer');
            $table->unsignedBigInteger('answer_group_id');
            $table->text('answer_group_type');
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
        Schema::dropIfExists('multi_answer_elements');
    }
}
