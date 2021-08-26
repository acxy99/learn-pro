<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plas', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'qtype' )->default("mcq");
            $table->string("question");
            $table->json("options");
            $table->json("answers");
            $table->integer("mark")->default(1);
            $table->string('status')->default("active");
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('course_id');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
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
        Schema::dropIfExists('plas');
    }
}
