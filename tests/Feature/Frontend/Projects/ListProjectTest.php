<?php

namespace Tests\Feature\Frontend\Project;

use App\Domains\Auth\Models\User;
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

        $this->get('/projects')->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_list_of_the_projects()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->get('/projects');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
}
