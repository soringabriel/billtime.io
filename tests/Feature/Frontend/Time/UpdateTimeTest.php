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
 * Class UpdateTimeTest.
 */
class UpdateTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_edit_a_time_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);
        
        $this->get("/time/{$time->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/time/{$time->id}/edit")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->get("/time/{$time->id}/edit")->assertOk();
    }

    /** @test */
    public function only_an_user_with_permissions_can_access_the_edit_a_time_page_for_another_user_from_the_same_organization()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $subuser->id, 
            'project_id' => $project->id
        ]);
        
        $this->get("/time/{$time->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/time/{$time->id}/edit")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->get("/time/{$time->id}/edit")->assertSessionHas(['flash_danger' => __('You don\'t have access to this model.')]);

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->get("/time/{$time->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_time_page_for_other_organization_users_times()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);
        
        $this->get("/time/{$time->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_time_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $response = $this->patch("/time/{$time->id}");

        $response->assertSessionHasErrors(['start_time', 'end_time', 'details']);
    }

    /** @test */
    public function a_time_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $new_project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }

    /** @test */
    public function a_time_of_another_user_can_be_updated_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $subuser->id, 
            'project_id' => $project->id
        ]);

        $new_project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }    

    /** @test */
    public function a_time_with_another_user_project_can_not_be_updated()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $another_client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $new_project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $another_client->id]);

        $response = $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $response->assertSessionHasErrors(['project_id']);

        $this->assertDatabaseMissing('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $time->project_id,
            'task' => $time->task,
            'details' => $time->details,
        ]);
    }

    /** @test */
    public function a_user_cannot_update_another_organization_user_time()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $new_project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $response = $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $new_project->id,
            'task' => 'task',
            'details' => 'details',
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $time->project_id,
            'task' => $time->task,
            'details' => $time->details,
        ]);
    }
}
