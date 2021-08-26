<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Course;
use App\File;

class FileTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $admin, $course, $file, $createRequest;
    
    public function setUp():void {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $this->course = factory(Course::class)->create();

        $this->file = UploadedFile::fake()->create('file.pdf');

        $this->createRequest = [
            'files' => [ $this->file ],
            'course_id' => $this->course->id,
            'course_slug' => $this->course->slug,
        ];

        Storage::fake('public');
    }

    /** @test */
    public function can_upload_file() {
        $this->actingAs($this->admin)->json('POST', '/api/admin/files', $this->createRequest);

        Storage::assertExists('courses/' . $this->course->slug . '/files/' . $this->file->name);
    }

    /** @test */
    public function can_update_file_name() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/files', $this->createRequest);
        $data = $response->getData();

        $originalFile = File::find($data->files->{0}->id);
        $fileExtension = pathinfo($originalFile->name, PATHINFO_EXTENSION);

        $updateRequest = [
            'id' => $originalFile->id,
            'name' => $this->faker->word,
        ];

        $this->actingAs($this->admin)->json('PUT', '/api/admin/files/' . $originalFile->id, $updateRequest);

        $updatedFile = File::find($originalFile->id);

        $this->assertEquals($originalFile->id, $updatedFile->id);
        $this->assertEquals($updateRequest['name'] . '.' . $fileExtension, $updatedFile->name);
        Storage::assertExists('courses/' . $this->course->slug . '/files/' . $updatedFile->name);
    }

    /** @test */
    public function can_delete_file() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/files', $this->createRequest);
        $data = $response->getData();

        $file = File::find($data->files->{0}->id);

        $this->assertNotNull($file);
        $this->assertCount(1, $this->course->files()->get());
        Storage::assertExists('courses/' . $this->course->slug . '/files/' . $file->name);

        $this->actingAs($this->admin)->json('DELETE', '/admin/files/' . $file->id);

        $this->assertNull(File::find($file->id));
        $this->assertCount(0, $this->course->files()->get());
        Storage::assertMissing('courses/' . $this->course->slug . '/files/' . $file->name);
    }
}
