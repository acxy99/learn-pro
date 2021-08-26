<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Course;
use App\Page;

class PageTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $admin, $pageTitle;
    
    public function setUp():void {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $sentence = $this->faker->sentence;
        $this->pageTitle = substr($sentence, 0, strlen($sentence) - 1);
    }

    /** @test */
    public function can_create_page() {
        $course = factory(Course::class)->create();
        // $page = factory(Page::class)->create(['course_id' => $course->id]);

        $request = [
            'title' => $this->pageTitle,
            'body' => $this->faker->paragraphs($nb = 3, $asText = true) ,
            'course_id' => $course->id,
        ];

        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/pages', $request);
        $data = $response->getData();

        $page = Page::find($data->page->id);

        $this->assertEquals($request['title'], $page->title);
        $this->assertEquals($request['body'], $page->body);
        $this->assertEquals($request['course_id'], $page->course_id);
    }

    /** @test */
    public function can_retrieve_page() {
        $course = factory(Course::class)->create();
        $page = factory(Page::class)->create(['course_id' => $course->id]);

        $retrievedPage = Page::find($page->id);

        $this->assertEquals($page->id, $retrievedPage->id);
        $this->assertEquals($course->id, $retrievedPage->course_id);
    }

    /** @test */
    public function can_update_page() {
        $course = factory(Course::class)->create();
        $originalPage = factory(Page::class)->create(['course_id' => $course->id]);

        $request = [
            'id' => $originalPage->id,
            'title' => 'new title',
            'body' => 'new content',
        ];

        $this->actingAs($this->admin)->json('PUT', '/api/admin/pages/' . $originalPage->id, $request);

        $updatedPage = Page::find($originalPage->id);

        $this->assertNotEquals($originalPage->title, $updatedPage->title);
        $this->assertNotEquals($originalPage->body, $updatedPage->body);
        $this->assertEquals($request['title'], $updatedPage->title);
        $this->assertEquals($request['body'], $updatedPage->body);
    }

    /** @test */
    public function can_delete_page() {
        $course = factory(Course::class)->create();
        $page = factory(Page::class)->create(['course_id' => $course->id]);

        $this->assertCount(1, $course->pages()->get());
        $this->assertNotNull(Page::find($page->id));

        $response = $this->actingAs($this->admin)->json('DELETE', '/admin/pages/' . $page->id);

        $this->assertCount(0, $course->pages()->get());
        $this->assertNull(Page::find($page->id));
    }
}
