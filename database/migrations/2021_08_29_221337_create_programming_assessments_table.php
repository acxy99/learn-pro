<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programming_assessments', function (Blueprint $table) {
            $table->increments('id');
            $table->string("question");
            $table->json("answer");
            $table->integer("mark")->default(1);
            $table->string('status')->default("active");
            $table->unsignedInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
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
        Schema::dropIfExists('programming_assessments');
    }
}
