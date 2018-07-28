<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Profile;

class ProfileRelationshipTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function profile_belongs_to_a_user() {
        $user = factory(User::class)->create();
        
        $profile = $user->profile()->save(
            factory(Profile::class)->create([
                'user_id' => $user->id,
            ])
        );

        $this->assertNotNull($profile->user);
    }
}
