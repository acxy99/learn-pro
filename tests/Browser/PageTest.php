<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Course;
use App\Page;

class PageTest extends DuskTestCase {
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function create_page() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/uecs3453')
                    ->click('@manage-pages-button')
                    ->click('@create-page-button')
                    ->waitFor('#body_ifr');

            $browser->driver->executeScript('tinyMCE.get(\'body\').setContent(\'content\')');

            $browser->type('title', 'Hello World')
                    ->click('@save-button')
                    ->waitUntilMissing('@save-button')
                    ->assertSee('Hello World')
                    ->assertSee('content');
        });
    }

    /** @test */
    public function view_page() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses/uecs3453')
                    ->click('@pages-tab')
                    ->waitFor('@pages-tab-content')
                    ->click('@hello-world')
                    ->assertSee('Hello World')
                    ->assertSee('content');
        });
    }

    /** @test */
    public function update_page() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/uecs3453/pages/hello-world')
                    ->click('@edit-button')
                    ->waitFor('#body_ifr');

            $browser->driver->executeScript('tinyMCE.get(\'body\').setContent(\'new content\')');

            $browser->click('@save-button')
                    ->waitUntilMissing('@save-button')
                    ->assertSee('Hello World')
                    ->assertSee('new content');
        });
    }
       
    /** @test */
    public function delete_page() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/uecs3453/pages/hello-world')
                    ->click('@delete-button')
                    ->acceptDialog()
                    ->waitForLocation('/admin/courses/uecs3453/pages')
                    ->assertDontSee('Hello World');
        });
    }
}
