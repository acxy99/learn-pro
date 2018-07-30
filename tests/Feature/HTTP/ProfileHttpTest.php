<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Profile;

class ProfileHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function frontend_api_update() {
        $user = factory(User::class)->create();
        $user->profile()->save(factory(Profile::class)->create(['user_id' => $user->id]));

        $request = [
            'user_id' => $user->id,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $response = $this->json('PUT', '/api/profiles/' . $user->id, $request);
        $response->assertOk();
    }
}
