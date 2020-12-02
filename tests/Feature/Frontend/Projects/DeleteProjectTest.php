<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectDeleted;
use App\Models\Project;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteProjectTest.
 */
class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->delete("/projects/{$project->id}");

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);

        Event::assertDispatched(ProjectDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_project_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $another_user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->delete("/projects/{$project->id}");

        $this->assertDatabaseHas('projects', ['id' => $project->id]);
    }
}
