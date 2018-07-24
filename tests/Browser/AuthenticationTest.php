<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

use App\User;

class AuthenticationTest extends DuskTestCase {
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function login() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', User::find(1)->email)
                    ->type('password', 'admin')
                    ->press('Login')
                    ->assertSee('Login successful.');
        });
    }

    /** @test */
    public function logout() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->click('@dropdown-toggle')
                    ->click('@logout-button')
                    ->waitFor('@alert-message')
                    ->assertSee('Logout successful.');
        });
    }
}
