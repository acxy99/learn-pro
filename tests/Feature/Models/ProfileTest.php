<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    public function can_retrieve_profile() {
        $this->user->profile()->save(factory(Profile::class)->create(['user_id' => $this->user->id]));

        $profile = Profile::find($this->user->id);

        $this->assertEquals($this->user->id, $profile->user_id);
        $this->assertEquals($this->user->profile, $profile);
    }

    /** @test */
    public function can_update_profile() {
        $this->user->profile()->save(factory(Profile::class)->create(['user_id' => $this->user->id]));
        $originalProfile = $this->user->profile;

        $updateRequest = [
            'user_id' => $this->user->id,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $this->actingAs($this->user)->json('PUT', '/api/profiles/' . $this->user->id, $updateRequest);

        $updatedProfile = Profile::find($this->user->id);

        $this->assertNotEquals($originalProfile, $updatedProfile);
        $this->assertEquals($updateRequest['first_name'], $updatedProfile->first_name);
        $this->assertEquals($updateRequest['last_name'], $updatedProfile->last_name);
    }
}
