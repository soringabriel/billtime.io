<?php

namespace Tests\Feature\Frontend\Schedule;

use App\Events\Schedule\ScheduleCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Schedule;
use App\Models\Client;
use App\Models\Project;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateScheduleTest.
 */
class CreateScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permission_can_access_the_create_a_schedule_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/schedules/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/schedules/create')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id, 
        ]);

        $this->get('/schedules/create')->assertOk();
    }

    /** @test */
    public function creating_a_schedule_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/schedules');

        $response->assertSessionHasErrors(['project_id']);
    }

    /** @test */
    public function a_schedule_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id, 
        ]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);
        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $response = $this->post('/schedules', [
            'project_id' => $project->id,
            'schedule_trigger' => 1,
            'price_per_hour' => 30,
            'tax' => 0,
        ]);

        $this->assertDatabaseHas('schedules', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'schedule_trigger' => 1,
            'price_per_hour' => 30,
            'tax' => 0,
        ]);

        Event::assertDispatched(ScheduleCreated::class);
    }
}
