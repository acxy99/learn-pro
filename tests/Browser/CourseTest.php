<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Course;

class CourseTest extends DuskTestCase {
    use DatabaseMigrations;

    public function setUp():void {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function create_course() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses')
                    ->click('@create-course-button')
                    ->type('code', 'ABCD0123')
                    ->type('title', 'Hello World')
                    ->type('description', 'description')
                    ->click('@primary-instructor-multiselect')
                    ->click('li.multiselect__element:nth-of-type(1)')
                    ->click('@save-button')
                    ->waitUntilMissing('@save-button')
                    ->assertSee('ABCD0123');
        });
    }

    /** @test */
    public function view_course() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                    ->waitFor('@courses')
                    ->click('@abcd0123')
                    ->assertPresent('@overview-tab-content');
        });
    }

    /** @test */
    public function update_course() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/abcd0123')
                    ->click('@edit-button')
                    ->type('title', 'Goodbye World')
                    ->type('description', 'new description')
                    ->click('@save-button')
                    ->waitForLocation('/admin/courses/abcd0123')
                    ->assertSee('Goodbye World');
        });
    }

    /** @test */
    public function delete_course() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/abcd0123')
                    ->click('@delete-button')
                    ->acceptDialog()
                    ->waitForLocation('/admin/courses')
                    ->assertDontSee('ABCD0123');
        });
    }
}
