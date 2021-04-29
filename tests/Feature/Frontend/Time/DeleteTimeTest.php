<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeDeleted;
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
 * Class DeleteTimeTest.
 */
class DeleteTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_time_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseMissing('time', ['id' => $time->id]);

        Event::assertDispatched(TimeDeleted::class);
    }
    
    /** @test */
    public function a_user_with_permissions_can_delete_a_time_that_belongs_to_another_user_from_the_same_organization()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.delete-all')->first()->id, 
        ]);

        $another_user = User::factory()->user()->create();
        $another_user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseMissing('time', ['id' => $time->id]);

        Event::assertDispatched(TimeDeleted::class);
    }

    /** @test */
    public function a_user_cannot_delete_a_time_that_belongs_to_another_organization()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.delete-all')->first()->id, 
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseHas('time', ['id' => $time->id]);
    }
        
    /** @test */
    public function multiple_times_can_be_deleted_in_bulk()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.delete-all')->first()->id, 
        ]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $time2 = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);

        $result = $this->delete("/time", [
            'times' => json_encode([$time->id, $time2->id]),
        ]);

        $this->assertDatabaseMissing('time', ['id' => $time->id]);

        $this->assertDatabaseMissing('time', ['id' => $time2->id]);

        Event::assertDispatched(TimeDeleted::class);
    }

        
    /** @test */
    public function a_user_cannot_delete_in_bulk_a_time_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.delete-all')->first()->id, 
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $time2 = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);

        $this->delete("/time", [
            'times' => [
                $time->id,
                $time2->id,
            ],
        ]);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);
    }
}
