<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Course;
use App\Page;
use App\User;

class PageHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $pageTitle;
    
    public function setUp():void {
        parent::setUp();

        $sentence = $this->faker->sentence;
        $this->pageTitle = substr($sentence, 0, strlen($sentence) - 1);
    }

    /** @test */
    public function admin_api_index() {
        $course = factory(Course::class)->create();
        factory(Page::class, 2)->create(['course_id' => $course->id]);

        $response = $this->json('GET', '/api/admin/courses/' . $course->id . '/pages');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function admin_api_store() {
        $course = factory(Course::class)->create();

        $request = [
            'title' => $this->pageTitle,
            'body' => $this->faker->paragraphs($nb = 3, $asText = true),
            'course_id' => $course->id,
        ];

        $response = $this->json('POST', '/api/admin/pages', $request);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_update() {
        $course = factory(Course::class)->create();
        $page = factory(Page::class)->create(['course_id' => $course->id]);

        $request = [
            'id' => $page->id,
            'title' => 'new title',
            'body' => 'new content',
        ];

        $response = $this->json('PUT', '/api/admin/pages/' . $page->id, $request);
        $response->assertOK();
    }

    /** @test */
    public function admin_web_destroy() {
        $course = factory(Course::class)->create();
        $page = factory(Page::class)->create(['course_id' => $course->id]);

        $admin = factory(User::class)->create();
        $admin->assign(1);

        $response = $this->actingAs($admin)->json('DELETE', '/admin/pages/' . $page->id);
        $response->assertOK();
    }
}
