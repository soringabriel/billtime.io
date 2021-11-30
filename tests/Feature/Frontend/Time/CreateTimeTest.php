<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Time;
use App\Models\Project;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateTimeTest.
 */
class CreateTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_create_a_time_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/time/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/time/create')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->get('/time/create')->assertOk();
    }

    /** @test */
    public function creating_a_time_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/time');

        $response->assertSessionHasErrors(['start_time', 'end_time']);
    }

    /** @test */
    public function a_time_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeCreated::class);
    }

    /** @test */
    public function a_time_with_another_organization_project_can_not_be_created()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $response = $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $response->assertSessionHasErrors(['project_id']);

        $this->assertDatabaseMissing('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);
    }

    /** @test */
    public function creating_a_time_requires_validation_if_new_project_is_0()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/time', [
            'new_project' => 0
        ]);

        $response->assertSessionHasErrors(['project_id']);
    }

    /** @test */
    public function creating_a_time_requires_validation_if_new_project_is_1()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/time', [
            'new_project' => 1
        ]);

        $response->assertSessionHasErrors(['project_name']);
    }

    /** @test */
    public function creating_a_time_requires_validation_if_new_project_is_1_and_new_client_is_0()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/time', [
            'new_project' => 1,
            'new_client' => 0,
        ]);

        $response->assertSessionHasErrors(['project_client_id']);
    }

    /** @test */
    public function creating_a_time_requires_validation_if_new_project_is_1_and_new_client_is_1()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/time', [
            'new_project' => 1,
            'new_client' => 1,
        ]);

        $response->assertSessionHasErrors(['client_name']);
    }

    /** @test */
    public function a_time_can_be_created_with_a_new_project()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'task' => 'https://task.ro',
            'details' => 'details',
            'new_project' => 1,
            'project_name' => 'newprojectforanewtime',
            'project_client_id' => $client->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'newprojectforanewtime',
            'client_id' => $client->id,
        ]);

        $project = Project::where('name', 'newprojectforanewtime')->first();

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeCreated::class);
    }

    /** @test */
    public function a_time_can_be_created_with_a_new_project_and_a_new_client()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'task' => 'https://task.ro',
            'details' => 'details',
            'new_project' => 1,
            'project_name' => 'newprojectforanewtime',
            'new_client' => 1,
            'client_name' => 'newclientfornewprojectforanewtime',
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => 'newclientfornewprojectforanewtime',
        ]);

        $client = Client::where('name', 'newclientfornewprojectforanewtime')->first();

        $this->assertDatabaseHas('projects', [
            'name' => 'newprojectforanewtime',
            'client_id' => $client->id,
        ]);

        $project = Project::where('name', 'newprojectforanewtime')->first();

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeCreated::class);
    }
}
