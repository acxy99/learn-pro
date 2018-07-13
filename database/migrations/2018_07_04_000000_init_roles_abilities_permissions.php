<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class InitRolesAbilitiesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $instructor = Bouncer::role()->create([
            'name' => 'instructor',
            'title' => 'Instructor',
        ]);

        $learner = Bouncer::role()->create([
            'name' => 'learner',
            'title' => 'Learner',
        ]);

        // abilities
        Bouncer::allow('admin')->to('view-dashboard');
        Bouncer::allow('instructor')->to('view-dashboard');

        Bouncer::allow('admin')->to('view-user');
        Bouncer::allow('admin')->to('create-user');
        Bouncer::allow('admin')->to('update-user');
        Bouncer::allow('admin')->to('delete-user');

        Bouncer::allow('admin')->to('view-profile');
        Bouncer::allow('admin')->to('create-profile');
        Bouncer::allow('admin')->to('update-profile');
        Bouncer::allow('admin')->to('delete-profile');

        Bouncer::allow('admin')->to('view-category');
        Bouncer::allow('admin')->to('create-category');
        Bouncer::allow('admin')->to('update-category');
        Bouncer::allow('admin')->to('delete-category');

        Bouncer::allow('admin')->to('view-course');
        Bouncer::allow('admin')->to('create-course');
        Bouncer::allow('admin')->to('update-course');
        Bouncer::allow('admin')->to('delete-course');

        Bouncer::allow('admin')->to('view-page');
        Bouncer::allow('admin')->to('create-page');
        Bouncer::allow('admin')->to('update-page');
        Bouncer::allow('admin')->to('delete-page');

        Bouncer::allow('admin')->to('view-file');
        Bouncer::allow('admin')->to('create-file');
        Bouncer::allow('admin')->to('update-file');
        Bouncer::allow('admin')->to('delete-file');

        $user = User::find(1);
        Bouncer::assign('admin')->to($user);
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
