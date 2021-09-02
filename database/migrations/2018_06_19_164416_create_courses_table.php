<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 8)->unique();
            $table->string('title')->index();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('num_ques_ans')->nullable();
            $table->unsignedInteger('passing_mark_beginner')->nullable();
            $table->unsignedInteger('passing_mark_intermediate')->nullable();
            $table->unsignedInteger('passing_mark_advanced')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
