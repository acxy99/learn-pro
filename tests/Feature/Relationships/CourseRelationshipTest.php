<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Course;
use App\Page;
use App\File;
use App\Category;

class CourseRelationshipTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function course_has_an_owner() {
        $course = factory(Course::class)->create();

        $this->assertNotNull($course->owner);
    }

    /** @test */
    public function course_can_have_instructors() {
        $course = factory(Course::class)->create();

        $users = factory(User::class, 3)->create()->pluck('id')->toArray();
        
        $course->instructors()->sync($users);

        $this->assertEquals(3, $course->instructors()->count());
    }

    /** @test */
    public function course_can_have_pages() {
        $course = factory(Course::class)->create();

        factory(Page::class, 4)->create(['course_id' => $course->id]);

        $this->assertEquals(4, $course->pages()->count());
    }

    /** @test */
    public function course_can_have_files() {
        $course = factory(Course::class)->create();

        factory(File::class, 5)->create(['course_id' => $course->id]);

        $this->assertEquals(5, $course->files()->count());
    }

    /** @test */
    public function course_can_have_categories() {
        $course = factory(Course::class)->create();

        $categories = factory(Category::class, 2)->create()->pluck('id')->toArray();

        $course->categories()->sync($categories);

        $this->assertEquals(2, $course->categories()->count());
    }
}
