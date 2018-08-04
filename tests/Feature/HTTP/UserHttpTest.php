<?php

namespace Tests\Feature\HTTP;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Profile;

class UserHttpTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function admin_api_index() {
        factory(User::class, 3)->create();

        $response = $this->json('GET', '/api/admin/users');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    /** @test */
    public function admin_api_show() {
        $user = factory(User::class)->create();

        $response = $this->json('GET', '/api/admin/users/' . $user->id);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_store() {
        $request = [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 2,
        ];

        $response = $this->json('POST', '/api/admin/users', $request);
        $response->assertOk();
    }

    /** @test */
    public function admin_api_update() {
        $user = factory(User::class)->create();
        $user->profile()->save(factory(Profile::class)->create(['user_id' => $user->id]));

        $request = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->json('PUT', '/api/admin/users/' . $user->id, $request);
        $response->assertOk();
    }

    /** @test */
    public function admin_web_destroy() {
        $user = factory(User::class)->create();

        $admin = factory(User::class)->create();
        $admin->assign(1);

        $response = $this->actingAs($admin)->json('DELETE', '/admin/users/' . $user->id);
        $response->assertOk();
    }
}
