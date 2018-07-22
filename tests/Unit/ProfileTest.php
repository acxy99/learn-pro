<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;

use App\User;
use App\Profile;

class ProfileTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $user;

    public function setUp() {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    
    /** @test */
    public function get_uploaded_profile_picture_path() {
        $profile = $this->user->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $this->user->id, 
                'picture' => UploadedFile::fake()->image('picture.jpg')->name,
            ])
        );
        
        $this->assertEquals('/storage/profiles/' . $profile->picture, $profile->picture_path);
    }

    /** @test */
    public function get_default_profile_picture_path() {
        $profile = $this->user->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $this->user->id,
            ])
        );

        $this->assertEquals('/storage/profiles/default-profile-picture.jpg', $profile->picture_path);
    }

    /** @test */
    public function profile_has_slug() {
        $profile = $this->user->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $this->user->id,
            ])
        );

        $this->assertNotNull($profile->slug);
    }
}
