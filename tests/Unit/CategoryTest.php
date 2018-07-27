<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Category;

class CategoryTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;
    
    /** @test */
    public function category_slug_is_generated_from_title() {
        $category = factory(Category::class)->create();

        $this->assertEquals(str_slug($category->title, '-'), $category->slug);
    }

    /** @test */
    public function get_uploaded_category_image_path() {
        $category = factory(Category::class)->create([
            'image' => UploadedFile::fake()->image('image.jpg')->name
        ]);

        $this->assertEquals(Storage::url('categories/' . $category->image), $category->image_path);
    }

    /** @test */
    public function get_default_category_image_path() {
        $category = factory(Category::class)->create();

        $this->assertEquals(Storage::url('categories/placeholder-image.png'), $category->image_path);
    }
}
