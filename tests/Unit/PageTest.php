<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Course;
use App\Page;

class PageTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function page_slug_is_generated_from_title() {
        $page = factory(Page::class)->create();

        $this->assertEquals(str_slug($page->title, '-'), $page->slug);
    }

    /** @test */
    public function search_page_by_title() {
        $page = factory(Page::class)->create(['title' => 'Event Handling']);
        $page = factory(Page::class)->create(['title' => 'Listening to Events']);
        $page = factory(Page::class)->create(['title' => 'Method Event Handlers']);
        $page = factory(Page::class)->create(['title' => 'Methods in Inline Handlers']);
        $page = factory(Page::class)->create(['title' => 'Event Modifiers']);

        $pages = Page::searchByTitle('Handler')->get();

        $this->assertEquals(2, $pages->count());
    }
}
