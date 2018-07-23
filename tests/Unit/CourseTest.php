<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;

use App\Course;

class CourseTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function course_slug_is_generated_from_code() {
        $course = factory(Course::class)->create();

        $this->assertEquals(str_slug($course->code, '-'), $course->slug);
    }

    /** @test */
    public function get_uploaded_course_image_path() {
        $course = factory(Course::class)->create([
            'image' => UploadedFile::fake()->image('image.jpg')->name
        ]);

        $this->assertEquals('/storage/courses/' . $course->image, $course->image_path);
    }

    /** @test */
    public function get_default_course_image_path() {
        $course = factory(Course::class)->create();

        $this->assertEquals('/storage/courses/placeholder-image.png', $course->image_path);
    }

    /** @test */
    public function search_course_by_code() {
        $course1 = factory(Course::class)->create(['code' => 'UECS1004']);
        $course2 = factory(Course::class)->create(['code' => 'MPU32033']);
        $course3 = factory(Course::class)->create(['code' => 'UALJ2013']);
        $course4 = factory(Course::class)->create(['code' => 'UECS1203']);
        $course5 = factory(Course::class)->create(['code' => 'UECM1633']);

        $courses = Course::searchByCode('UECS')->get();

        $this->assertEquals(2, $courses->count());
    }

    /** @test */
    public function search_course_by_title() {
        $course1 = factory(Course::class)->create(['title' => 'Software Testing']);
        $course2 = factory(Course::class)->create(['title' => 'Software Design']);
        $course3 = factory(Course::class)->create(['title' => 'Data Mining']);
        $course4 = factory(Course::class)->create(['title' => 'Web Application Development']);
        $course5 = factory(Course::class)->create(['title' => 'Software Construction and Configuration']);

        $courses = Course::searchByTitle('Software')->get();

        $this->assertEquals(3, $courses->count());
    }
}
