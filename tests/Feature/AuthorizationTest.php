<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase {
    use RefreshDatabase;

    protected $admin, $instructor, $learner;

    public function setUp() {
        parent::setUp();

        $this->admin = factory(User::class)->create();
        $this->admin->assign(1);

        $this->instructor = factory(User::class)->create();
        $this->instructor->assign(2);

        $this->learner = factory(User::class)->create();
        $this->learner->assign(3);
    }

    /** @test */
    public function accessDashboardAsGuest() {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function accessDashboardAsAdmin() {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    public function accessDashboardAsInstructor() {
        $response = $this->actingAs($this->instructor)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    public function accessDashboardAsLearner() {
        $response = $this->actingAs($this->learner)->get('/admin');

        $response->assertStatus(403);
    }
}
