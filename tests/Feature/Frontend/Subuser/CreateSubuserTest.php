<?php

namespace Tests\Feature\Frontend\Subuser;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class CreateSubuserTest.
 */
class CreateSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_logged_in_user_can_access_the_create_subuser_page()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $response = $this->get('/subuser/create');

        $response->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_create_subuser_page()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get('/subuser/create');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function create_subuser_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $response = $this->post('/subuser');

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function subuser_email_needs_to_be_unique()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post('/subuser', [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_parent_user_can_create_new_subuser()
    {
        Notification::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $response = $this->post('/subuser', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
        ]);

        $this->assertDatabaseHas(
            'users',
            [
                'type' => User::TYPE_USER,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'parent_user_id' => $user->id,
                'active' => true,
            ]
        );

        $response->assertSessionHas(['flash_success' => __('The user was successfully created.')]);

        $user = User::where('email', 'john@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
