<?php

namespace Tests\Feature\Relationships;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Profile;
use App\Course;

class UserRelationshipTest extends TestCase {
    use WithFaker;
    use RefreshDatabase;

    public function setUp():void {
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
    public function user_has_a_profile() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/users', $this->createRequest);
        $data = $response->getData();

        $user = User::find($data->user->id);

        $this->assertNotNull($user->profile);
    }

    /** @test */
    public function user_has_a_role() {
        $response = $this->actingAs($this->admin)->json('POST', '/api/admin/users', $this->createRequest);
        $data = $response->getData();

        $user = User::find($data->user->id);

        $this->assertEquals('instructor', $user->role->name);
    }

    /** @test */
    public function user_can_own_courses() {
        $user = factory(User::class)->create();

        factory(Course::class, 3)->create(['owner_id' => $user->id]);

        $this->assertEquals(3, $user->owningCourses()->count());
    }

    /** @test */
    public function user_can_teach_courses() {
        $user = factory(User::class)->create();

        $courses = factory(Course::class, 2)->create();
        foreach ($courses as $course) {
            $course->instructors()->sync($user->id);
        }

        $this->assertEquals(2, $user->teachingCourses()->count());
    }
}
