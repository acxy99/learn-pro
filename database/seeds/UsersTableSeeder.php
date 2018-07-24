<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'username' => 'admin',
        ]);
        DB::table('users')->insert([
            'email' => 'instructor@instructor.com',
            'password' => bcrypt('instructor'),
            'username' => 'instructor',
        ]);
        DB::table('users')->insert([
            'email' => 'learner@learner.com',
            'password' => bcrypt('learner'),
            'username' => 'learner',
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
            'slug' => 'admin',
        ]);
        DB::table('profiles')->insert([
            'user_id' => 2,
            'slug' => 'instructor',
        ]);
        DB::table('profiles')->insert([
            'user_id' => 3,
            'slug' => 'learner',
        ]);

        $admin = User::find(1);
        Bouncer::assign('admin')->to($admin);

        $instructor = User::find(2);
        Bouncer::assign('instructor')->to($instructor);

        $learner = User::find(3);
        Bouncer::assign('learner')->to($learner);
    }
}
