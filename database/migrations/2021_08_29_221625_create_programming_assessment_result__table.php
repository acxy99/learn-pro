<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingAssessmentResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programming_assessment_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('learner_id');
            $table->json('answers');
            $table->float('obtain_mark');
            $table->boolean('is_pass')->default(false);
            $table->unsignedInteger('topic_id');
            $table->foreign('learner_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('programming_assessment_result_');
    }
}
