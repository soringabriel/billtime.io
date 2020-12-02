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

        $this->get('/project')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/project')->assertOk();
    }
}
