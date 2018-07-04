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
        // roles
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
        Bouncer::allow('admin')->to('manage-user');

        Bouncer::allow('admin')->to('view-category');
        Bouncer::allow('admin')->to('create-category');
        Bouncer::allow('admin')->to('manage-category');

        Bouncer::allow('admin')->to('view-course');
        Bouncer::allow('admin')->to('create-course');
        Bouncer::allow('admin')->to('manage-course');
        Bouncer::allow('instructor')->to('view-course');
        Bouncer::allow('instructor')->to('create-course');
        Bouncer::allow('instructor')->to('manage-course');

        Bouncer::allow('admin')->to('view-page');
        Bouncer::allow('admin')->to('create-page');
        Bouncer::allow('admin')->to('manage-page');
        Bouncer::allow('instructor')->to('view-page');
        Bouncer::allow('instructor')->to('create-page');
        Bouncer::allow('instructor')->to('manage-page');

        Bouncer::allow('admin')->to('view-file');
        Bouncer::allow('admin')->to('create-file');
        Bouncer::allow('admin')->to('manage-file');
        Bouncer::allow('instructor')->to('view-file');
        Bouncer::allow('instructor')->to('create-file');
        Bouncer::allow('instructor')->to('manage-file');

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
