<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class AuthenticationTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function validLoginCredentials() {
        $user = factory(User::class)->create([
            'email' => 'testuser@email.com',
            'password' => bcrypt('testpassword')
        ]);
        
        $response = $this->post('/login', [
            'email' => 'testuser@email.com',
            'password' => 'testpassword',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function invalidLoginCredentials() {
        $user = factory(User::class)->create([
            'email' => 'testuser@email.com',
            'password' => bcrypt('testpassword')
        ]);
        
        $response = $this->post('/login', [
            'email' => 'testuser@email.com',
            'password' => 'invalidpassword',
        ]);

        $this->assertGuest();
    }
}
