<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Category;

class CategoryTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $admin, $createRequest;

    public function setUp() {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $sentence = $this->faker->sentence;
        $title = substr($sentence, 0, strlen($sentence) - 1);

        $this->createRequest = [
            'title' => $title,
            'description' => $this->faker->text,
        ];
    }

    /** @test */
    public function can_create_category() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/categories', $this->createRequest);
        $data = $response->getData();

        $category = Category::find($data->category->id);

        $this->assertEquals($this->createRequest['title'], $category->title);
        $this->assertEquals($this->createRequest['description'], $category->description);
    }

    /** @test */
    public function can_retrieve_category() {
        $category = factory(Category::class)->create();

        $response = $this->actingAs($this->admin)->json('GET', '/api/admin/categories/' . $category->id);
        $data = $response->getData();

        $retrievedCategory = $data->data;

        $this->assertEquals($category->id, $retrievedCategory->id);
    }

    /** @test */
    public function can_update_category() {
        $originalCategory = factory(Category::class)->create();

        $updateRequest = [
            'title' => 'Category Title',
            'description' => 'Category description',
        ];

        $this->actingAs($this->admin)->json('PUT', '/api/admin/categories/' . $originalCategory->id, $updateRequest);

        $updatedCategory = Category::find($originalCategory->id);

        $this->assertEquals($updateRequest['title'], $updatedCategory->title);
        $this->assertNotEquals($originalCategory->title, $updatedCategory->title);
    }

    /** @test */
    public function can_delete_category() {
        $category = factory(Category::class)->create();

        $this->assertNotNull(Category::find($category->id));

        $this->actingAs($this->admin)->json('DELETE', '/admin/categories/' . $category->id, []);

        $this->assertNull(Category::find($category->id));
    }
}
