<?php

namespace Tests\Feature\Frontend\Project;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListProjectTest.
 */
class ListProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_list_of_the_projects()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/projects')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/clients')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.projects.access')->first()->id, 
        ]);

        $this->get('/projects')->assertOk();
    }
}
