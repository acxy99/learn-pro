<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\File;

class FileRelationshipTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function file_belongs_to_a_course() {
        $file = factory(File::class)->create();

        $this->assertNotNull($file->course);
    }
}
