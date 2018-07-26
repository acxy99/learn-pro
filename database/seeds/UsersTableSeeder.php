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

        $admin = User::where('username', 'admin')->first();
        $instructor = User::where('username', 'instructor')->first();
        $learner = User::where('username', 'learner')->first();

        DB::table('profiles')->insert([
            'user_id' => $admin->id,
            'slug' => 'admin',
        ]);
        DB::table('profiles')->insert([
            'user_id' => $instructor->id,
            'slug' => 'instructor',
        ]);
        DB::table('profiles')->insert([
            'user_id' => $learner->id,
            'slug' => 'learner',
        ]);

        Bouncer::assign('admin')->to($admin);
        Bouncer::assign('instructor')->to($instructor);
        Bouncer::assign('learner')->to($learner);
    }
}
