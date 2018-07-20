<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Profile;
use App\User;

use App\Http\Controllers\Admin\UserController;

class UserTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    protected $admin, $createRequest;

    public function setUp() {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $this->createRequest = [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'role' => 2, // instructor
        ];
    }

    /** @test */
    public function can_create_user() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/users', $this->createRequest);
        $data = $response->getData();

        $user = User::find($data->user->id);

        $this->assertEquals($this->createRequest['username'], $user->username);
    }

    /** @test */
    public function created_user_has_role() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/users', $this->createRequest);
        $data = $response->getData();

        $user = User::find($data->user->id);

        $this->assertEquals('instructor', $user->role->name);
    }

    /** @test */
    public function created_user_has_profile() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/users', $this->createRequest);
        $data = $response->getData();

        $user = User::find($data->user->id);

        $this->assertNotNull($user->profile);
    }

    /** @test */
    public function can_retrieve_user() {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin)->json('GET', '/api/admin/users/' . $user->id);
        $data = $response->getData();

        $retrievedUser = $data->data;

        $this->assertEquals($user->id, $retrievedUser->id);
    }

    /** @test */
    public function can_update_user() {
        $originalUser = factory(User::class)->create();
        $originalUser->profile()->save(factory(Profile::class)->create(['user_id' => $originalUser->id]));

        $updateRequest = [
            'id' => $originalUser->id,
            'username' => $originalUser->username,
            'email' => 'newemail@email.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];

        $response = $this->actingAs($this->admin)->json('PUT', '/api/admin/users/' . $originalUser->id, $updateRequest);
        $data = $response->getData();

        $updatedUser = User::find($originalUser->id);

        $this->assertEquals($updateRequest['email'], $updatedUser->email);
        $this->assertNotEquals($originalUser->email, $updatedUser->email);
    }

    /** @test */
    public function can_delete_user() {
        $user = factory(User::class)->create();

        $this->assertNotNull(User::find($user->id));

        $response = $this->actingAs($this->admin)->json('DELETE', '/admin/users/' . $user->id, []);
        $data = $response->getData();

        $this->assertNull(User::find($user->id));
    }
}
