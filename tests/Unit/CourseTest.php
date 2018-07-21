<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Course;

class CourseTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $admin, $createRequest;
    
    public function setUp() {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $sentence = $this->faker->sentence;
        $title = substr($sentence, 0, strlen($sentence) - 1);

        $this->createRequest = [
            'code' => $this->faker->bothify('????####'),
            'title' => $title,
            'description' => $this->faker->text,
            'owner_id' => factory(User::class)->create()->id,
        ];
    }

    /** @test */
    public function can_create_course() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/courses', $this->createRequest);
        $data = $response->getData();

        $course = Course::find($data->course->id);

        $this->assertEquals($this->createRequest['code'], $course->code);
        $this->assertEquals($this->createRequest['title'], $course->title);
        $this->assertEquals($this->createRequest['description'], $course->description);
        $this->assertEquals($this->createRequest['owner_id'], $course->owner_id);
    }

    /** @test */
    public function can_retrieve_course() {
        $course = factory(Course::class)->create();

        $response = $this->actingAs($this->admin)->json('GET', '/api/admin/courses/' . $course->id);
        $data = $response->getData();

        $retrievedCourse = $data->data;

        $this->assertEquals($course->id, $retrievedCourse->id);
    }

    /** @test */
    public function can_update_course() {
        $originalCourse = factory(Course::class)->create();

        $updateRequest = [
            'id' => $originalCourse->id,
            'code' => $originalCourse->code,
            'title' => 'new title',
            'description' => 'new description',
        ];

        $this->actingAs($this->admin)->json('PUT', '/api/admin/courses/' . $originalCourse->id, $updateRequest);

        $updatedCourse = Course::find($originalCourse->id);

        $this->assertEquals($originalCourse->code, $updatedCourse->code);
        $this->assertNotEquals($originalCourse->title, $updatedCourse->title);
        $this->assertNotEquals($originalCourse->description, $updatedCourse->description);
    }

    /** @test */
    public function can_delete_course() {
        $course = factory(Course::class)->create();

        $this->assertNotNull(Course::find($course->id));

        $this->actingAs($this->admin)->json('DELETE', '/admin/courses/' . $course->id);

        $this->assertNull(Course::find($course->id));
    }
}
