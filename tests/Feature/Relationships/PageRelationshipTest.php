<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Course;
use App\Page;

class PageRelationshipTest extends TestCase {
    use RefreshDatabase;
    
    /** @test */
    public function page_belongs_to_a_course() {
        $page = factory(Page::class)->create();

        $this->assertNotNull($page->course);
    }

    /** @test */
    public function page_can_have_a_parent() {
        $parent = factory(Page::class)->create();
        $page = factory(Page::class)->create(['parent_id' => $parent->id]);

        $this->assertEquals($parent->id, $page->parent->id);
    }

    /** @test */
    public function page_can_have_children() {
        $page = factory(Page::class)->create();
        factory(Page::class, 3)->create(['parent_id' => $page->id]);

        $this->assertEquals(3, $page->children()->count());
    }

    /** @test */
    public function can_retrieve_root_page() {
        $root = factory(Page::class)->create();
        $level1 = factory(Page::class)->create(['parent_id' => $root->id]);
        $level2 = factory(Page::class)->create(['parent_id' => $level1->id]);
        $level3 = factory(Page::class)->create(['parent_id' => $level2->id]);

        $this->assertEquals($root->id, $level3->root()->id);
    }
}
