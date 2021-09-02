<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeapResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leap_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('learner_id');
            $table->float('obtain_mark');
            $table->json('answers');
            $table->string('learner_type')->default("easy");
            $table->unsignedInteger('course_id');
            $table->foreign('learner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::dropIfExists('leap_results');
    }
}
