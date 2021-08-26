<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Course;
use App\Page;
use App\File;

class CourseHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $courseTitle;
    
    public function setUp():void {
        parent::setUp();

        $sentence = $this->faker->sentence;
        $this->courseTitle = substr($sentence, 0, strlen($sentence) - 1);
    }

    /** @test */
    public function admin_api_index() {
        factory(Course::class, 3)->create();

        $admin = factory(User::class)->create();
        $admin->assign(1);

        $request = ['user_id' => $admin->id];

        $response = $this->json('GET', '/api/admin/courses', $request);
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    /** @test */
    public function admin_api_show() {
        $course = factory(Course::class)->create();
        
        $response = $this->json('GET', '/api/admin/courses/' . $course->id);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_store() {
        $createRequest = [
            'code' => $this->faker->bothify('????####'),
            'title' => $this->courseTitle,
            'description' => $this->faker->text,
            'owner_id' => factory(User::class)->create()->id,
        ];

        $response = $this->json('POST', '/api/admin/courses', $createRequest);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_update() {
        $course = factory(Course::class)->create();

        $updateRequest = [
            'id' => $course->id,
            'code' => $course->code,
            'title' => $this->courseTitle,
            'description' => $this->faker->text,
            'owner_id' => $course->owner_id,
        ];

        $response = $this->json('PUT', '/api/admin/courses/' . $course->id, $updateRequest);
        $response->assertOK();
    }

    /** @test */
    public function frontend_api_index() {
        factory(Course::class, 5)->create();

        $response = $this->json('GET', '/api/courses');
        $response->assertOk()->assertJsonCount(5, 'data');
    }

    /** @test */
    public function frontend_api_pages() {
        $course = factory(Course::class)->create();
        factory(Page::class, 2)->create(['course_id' => $course->id]);

        $response = $this->json('GET', '/api/courses/' . $course->id . '/pages');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function frontend_api_files() {
        $course = factory(Course::class)->create();
        factory(File::class, 3)->create(['course_id' => $course->id]);

        $response = $this->json('GET', '/api/courses/' . $course->id . '/files');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    /** @test */
    public function frontend_api_new() {
        factory(Course::class, 5)->create();

        $response = $this->json('GET', '/api/courses/new');
        $response->assertOk()->assertJsonCount(4, 'data');
    }

    /** @test */
    public function admin_web_destroy() {
        $course = factory(Course::class)->create();

        $admin = factory(User::class)->create();
        $admin->assign(1);
        
        $response = $this->actingAs($admin)->json('DELETE', '/admin/courses/' . $course->id);
        $response->assertOk();
    }
}
