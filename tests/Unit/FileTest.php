<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Course;
use App\File;

class FileTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function get_file_path() {
        $file = factory(File::class)->create();

        $this->assertEquals('/storage/courses/' . $file->course->slug . '/' . $file->name, $file->file_path);
    }

    /** @test */
    public function search_by_file_name() {
        factory(File::class)->create(['name' => 'file.pdf']);
        factory(File::class)->create(['name' => 'image.jpg']);
        factory(File::class)->create(['name' => 'picture.png']);
        factory(File::class)->create(['name' => 'file.docx']);
        factory(File::class)->create(['name' => 'file.txt']);

        $files = File::searchByName('file')->get();

        $this->assertEquals(3, $files->count());
    }
}
