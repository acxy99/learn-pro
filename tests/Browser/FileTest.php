<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Course;
use App\File;

class FileTest extends DuskTestCase {
    use DatabaseMigrations;

    public function setUp():void {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function upload_file() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/uecs3453')
                    ->click('@manage-files-button')
                    ->click('@upload-files-button')
                    ->attach('files', storage_path('app/public/testing/test-file.pptx'))
                    ->click('@upload-button')
                    ->waitUntilMissing('@upload-button')
                    ->waitFor('@files')
                    ->assertSee('test-file.pptx');
        });
    }

    /** @test */
    public function view_file() {
        $this->browse(function (Browser $browser) {
            $browser->resize(1024, 800)
                    ->visit('/courses/uecs3453')
                    ->click('@files-tab')
                    ->waitFor('@files-tab-content')
                    ->waitFor('@files')
                    ->assertSee('test-file.pptx');
        });
    }

    /** @test */
    public function delete_file() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/courses/uecs3453/files')
                    ->waitFor('@files')
                    ->mouseover('@test-file.pptx')
                    ->click('@test-file.pptx-delete-button')
                    ->acceptDialog()
                    ->waitUntilMissing('@test-file.pptx')
                    ->assertDontSee('test-file.pptx');
        });
    }
}
