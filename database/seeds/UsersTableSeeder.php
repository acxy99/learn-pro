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
        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'username' => 'admin',
        ]);
        $instructor = factory(User::class)->create([
            'email' => 'instructor@instructor.com',
            'password' => bcrypt('instructor'),
            'username' => 'instructor',
        ]);
        $learner = factory(User::class)->create([
            'email' => 'learner@learner.com',
            'password' => bcrypt('learner'),
            'username' => 'learner',
        ]);

        $admin->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $admin->id,
            ])
        );
        $instructor->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $instructor->id,
            ])
        );
        $learner->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $learner->id,
            ])
        );

        Bouncer::assign('admin')->to($admin);
        Bouncer::assign('instructor')->to($instructor);
        Bouncer::assign('learner')->to($learner);
    }
}
