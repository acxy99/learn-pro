<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

use App\User;

class DashboardTest extends DuskTestCase {
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function login_as_admin() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->assertSeeIn('@navbar', 'Dashboard');
        });
    }

    /** @test */
    public function login_as_instructor() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit('/')
                    ->assertSeeIn('@navbar', 'Dashboard');
        });
    }

    /** @test */
    public function login_as_learner() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(3))
                    ->visit('/')
                    ->assertDontSeeIn('@navbar', 'Dashboard');
        });
    }

    /** @test */
    public function view_dashboard_as_admin() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->assertVisible('@course-card')
                    ->assertVisible('@category-card')
                    ->assertVisible('@user-card');
        });
    }

    /** @test */
    public function view_dashboard_as_instructor() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit('/admin')
                    ->assertVisible('@course-card')
                    ->assertMissing('@category-card')
                    ->assertMissing('@user-card');
        });
    }

    /** @test */
    public function view_dashboard_as_learner() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(3))
                    ->visit('/admin')
                    ->assertVisible('@error-403');
        });
    }
}
