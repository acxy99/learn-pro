<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Course;
use App\Category;

class CategoryRelationshipTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function category_can_have_courses() {
        $category = factory(Category::class)->create();

        $courses = factory(Course::class, 3)->create()->pluck('id')->toArray();

        $category->courses()->sync($courses);

        $this->assertEquals(3, $category->courses()->count());
    }
}
