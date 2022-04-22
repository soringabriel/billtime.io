<?php

namespace Tests\Feature\Frontend\Schedule;

use App\Events\Schedule\ScheduleUpdated;
use App\Models\Schedule;
use App\Models\Client;
use App\Models\Project;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateScheduleTest.
 */
class UpdateScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_edit_a_schedule_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);
        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);
        
        $schedule = Schedule::factory()->create(['user_id' => $user->id, 'project_id' => $project->id]);
        
        $this->get("/schedules/{$schedule->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/schedules/{$schedule->id}/edit")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $this->get("/schedules/{$schedule->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_schedule_page_for_other_organizations_schedules()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);
        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $schedule = Schedule::factory()->create(['user_id' => $another_user->id, 'project_id' => $project->id]);
        
        $this->get("/schedules/{$schedule->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_schedule_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);
        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $schedule = Schedule::factory()->create(['user_id' => $user->id, 'project_id' => $project->id]);

        $response = $this->patch("/schedules/{$schedule->id}");

        $response->assertSessionHasErrors(['project_id']);
    }

    /** @test */
    public function a_schedule_can_be_updated()
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

        $schedule = Schedule::factory()->create(['user_id' => $user->id, 'project_id' => $project->id]);

        $this->patch("/schedules/{$schedule->id}", [
            'project_id' => $project->id,
            'schedule_trigger' => 1,
            'price_per_hour' => 30,
            'tax' => 0,
        ]);

        $this->assertDatabaseHas('schedules', [
            'project_id' => $project->id,
            'schedule_trigger' => 1,
            'price_per_hour' => 30,
            'tax' => 0,
        ]);

        Event::assertDispatched(ScheduleUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_organization_schedule()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);
        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $schedule = Schedule::factory()->create(['user_id' => $another_user->id, 'project_id' => $project->id]);

        $response = $this->patch("/schedules/{$schedule->id}", [
            'project_id' => $project->id,
            'schedule_trigger' => 1,
            'price_per_hour' => 30,
            'tax' => 0,
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('schedules', [
            'project_id' => $schedule->project_id,
            'schedule_trigger' => $schedule->schedule_trigger,
            'price_per_hour' => $schedule->price_per_hour,
            'tax' => $schedule->tax,
        ]);
    }
}
