<?php

namespace Tests\Feature\Frontend\Project;

use App\Domains\Auth\Models\User;
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

        $this->get('/projects')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/projects')->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_list_of_the_projects()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get('/projects');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
}
