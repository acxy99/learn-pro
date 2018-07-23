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
    public function can_have_children() {
        $page = factory(Page::class)->create();
        factory(Page::class, 2)->create(['parent_id' => $page->id]);

        $this->assertCount(2, $page->children()->get());
    }

    /** @test */
    public function can_have_parent() {
        $parentPage = factory(Page::class)->create();
        $page = factory(Page::class)->create(['parent_id' => $parentPage->id]);

        $this->assertEquals($parentPage->id, $page->parent->id);
    }

    /** @test */
    public function can_retrieve_root() {
        $root = factory(Page::class)->create();
        $level1 = factory(Page::class)->create(['parent_id' => $root->id]);
        $level2 = factory(Page::class)->create(['parent_id' => $level1->id]);
        $level3 = factory(Page::class)->create(['parent_id' => $level2->id]);

        $this->assertEquals($root->id, $level3->root()->id);
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
