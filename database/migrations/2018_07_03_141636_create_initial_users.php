<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'username' => 'admin',
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
            'slug' => 'admin',
        ]);

        DB::table('users')->insert([
            'email' => 'instructor@instructor.com',
            'password' => bcrypt('instructor'),
            'username' => 'instructor',
        ]);

        DB::table('profiles')->insert([
            'user_id' => 2,
            'slug' => 'instructor',
        ]);

        DB::table('users')->insert([
            'email' => 'learner@learner.com',
            'password' => bcrypt('learner'),
            'username' => 'learner',
        ]);

        DB::table('profiles')->insert([
            'user_id' => 3,
            'slug' => 'learner',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
