<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Category;
use App\Course;
use App\User;

class CategoryHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $categoryTitle;
    
    public function setUp() {
        parent::setUp();

        $sentence = $this->faker->sentence;
        $this->categoryTitle = substr($sentence, 0, strlen($sentence) - 1);
    }

    /** @test */
    public function admin_api_index() {
        factory(Category::class, 3)->create();

        $response = $this->json('GET', '/api/admin/categories');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    /** @test */
    public function admin_api_show() {
        $category = factory(Category::class)->create();

        $response = $this->json('GET', '/api/admin/categories/' . $category->id);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_courses() {
        $category = factory(Category::class)->create();

        $courses = factory(Course::class, 2)->create()->pluck('id')->toArray();
    
        $category->courses()->sync($courses);

        $response = $this->json('GET', '/api/admin/categories/' . $category->id . '/courses');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function admin_api_store() {
        $request = [
            'title' => $this->categoryTitle,
            'description' => $this->faker->text,
        ];

        $response = $this->json('POST', '/api/admin/categories', $request);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_update() {
        $category = factory(Category::class)->create();

        $request = [
            'title' => $this->categoryTitle,
            'description' => $this->faker->text,
        ];

        $response = $this->json('PUT', '/api/admin/categories/' . $category->id, $request);
        $response->assertOk();
    }

    /** @test */
    public function frontend_api_index() {
        factory(Category::class, 3)->create();

        $response = $this->json('GET', '/api/categories');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    /** @test */
    public function frontend_api_courses() {
        $category = factory(Category::class)->create();

        $courses = factory(Course::class, 2)->create()->pluck('id')->toArray();
    
        $category->courses()->sync($courses);

        $response = $this->json('GET', '/api/categories/' . $category->id . '/courses');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function frontend_api_popular() {
        factory(Category::class, 5)->create();

        $response = $this->json('GET', '/api/categories/popular');
        $response->assertOk()->assertJsonCount(4, 'data');
    }

    /** @test */
    public function admin_web_destroy() {
        $category = factory(Category::class)->create();

        $admin = factory(User::class)->create();
        $admin->assign(1);

        $response = $this->actingAs($admin)->json('DELETE', '/admin/categories/' . $category->id);
        $response->assertOk();
    }
}
