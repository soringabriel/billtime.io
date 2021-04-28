<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeUpdated;
use App\Models\Time;
use App\Models\Client;
use App\Models\Project;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class ToggleBilledTimeTest.
 */
class ToggleBilledTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_cannot_toggle_another_user_time()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.mark-billed')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $response = $this->patch("/time/{$time->id}/toggleBilled");

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $time->project_id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => $time->billed,
        ]);
    }

    /** @test */
    public function a_non_billed_time_can_be_marked_as_billed_only_by_an_user_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->patch("/time/{$time->id}/toggleBilled")->assertSessionHas(['flash_danger' => __('You do not have access to do that.')]);

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.mark-billed')->first()->id, 
        ]);

        $this->patch("/time/{$time->id}/toggleBilled");

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $project->id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => 1,
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }

    /** @test */
    public function a_billed_time_can_be_marked_as_not_billed_only_by_an_user_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id,
            'billed' => 1,
        ]);

        $this->patch("/time/{$time->id}/toggleBilled")->assertSessionHas(['flash_danger' => __('You do not have access to do that.')]);

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.mark-billed')->first()->id, 
        ]);

        $this->patch("/time/{$time->id}/toggleBilled");

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $project->id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => 0,
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }
}
