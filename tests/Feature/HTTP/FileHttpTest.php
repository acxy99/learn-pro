<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\File;

class FileHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;
    
    public function setUp():void {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function admin_api_index() {
        $course = factory(Course::class)->create();
        factory(File::class, 2)->create(['course_id' => $course->id]);

        $response = $this->json('GET', '/api/courses/' . $course->id . '/files');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function admin_api_store() {
        $course = factory(Course::class)->create();

        $request = [
            'files' => [ UploadedFile::fake()->create('file.pdf') ],
            'course_id' => $course->id,
        ];

        $response = $this->json('POST', '/api/admin/files', $request);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_update() {
        $course = factory(Course::class)->create();
        $file = factory(File::class)->create(['course_id' => $course->id]);
        Storage::putFileAs('courses/' . $course->slug . '/files', UploadedFile::fake()->create($file->name), $file->name);

        $request = [
            'id' => $file->id,
            'name' => $this->faker->word,
        ];

        $response = $this->json('PUT', '/api/admin/files/' . $file->id, $request);
        $response->assertOK();
    }
}
