<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectCreated;
use App\Domains\Auth\Models\User;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateProjectTest.
 */
class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_create_a_project_page()
    {
        $user = User::factory()->user()->create();
        
        $this->get('/projects/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/projects/create')->assertOk();
    }
    
    /** @test */
    public function a_subuser_cannot_access_the_create_a_project_page()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get("/projects/create");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function creating_a_project_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);
        
        $response = $this->post('/projects');

        $response->assertSessionHasErrors(['name', 'client_id']);
    }

    /** @test */
    public function a_project_with_another_user_client_id_can_not_be_created()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);
        
        $response = $this->post('/projects', [
            'name' => 'name',
            'client_id' => $client->id,
        ]);

        $response->assertSessionHasErrors(['client_id']);
    }

    /** @test */
    public function a_project_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->post('/projects', [
            'name' => 'name',
            'client_id' => $client->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'name',
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        Event::assertDispatched(ProjectCreated::class);
    }
}
