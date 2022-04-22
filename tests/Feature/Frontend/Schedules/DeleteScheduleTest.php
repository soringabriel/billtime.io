<?php

namespace Tests\Feature\Frontend\Schedule;

use App\Events\Schedule\ScheduleDeleted;
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
 * Class DeleteScheduleTest.
 */
class DeleteScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_schedule_can_be_deleted_only_by_a_user_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);
        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $schedule = Schedule::factory()->create(['user_id' => $user->id, 'project_id' => $project->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('schedules', ['id' => $schedule->id]);

        $this->delete("/schedules/{$schedule->id}")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $response = $this->delete("/schedules/{$schedule->id}");

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);

        Event::assertDispatched(ScheduleDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_schedule_that_belongs_to_another_organization()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);
        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $schedule = Schedule::factory()->create(['user_id' => $another_user->id, 'project_id' => $project->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('schedules', ['id' => $schedule->id]);

        $this->delete("/schedules/{$schedule->id}");

        $this->assertDatabaseHas('schedules', ['id' => $schedule->id]);
    }
}
