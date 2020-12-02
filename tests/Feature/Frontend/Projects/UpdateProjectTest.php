<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectUpdated;
use App\Models\Project;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateProjectTest.
 */
class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_edit_a_project_page()
    {
        $user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);
        
        $this->get("/project/{$project->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/project/{$project->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_project_page_for_other_users_projects()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $another_user->id]);
        
        $this->get("/project/{$project->id}/edit")->assertRedirect('/project');
    }

    /** @test */
    public function updating_a_project_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->patch("/project/{$project->id}");

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_project_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $this->patch("/project/{$project->id}", [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        $this->assertDatabaseHas('project', [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        Event::assertDispatched(ProjectUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_user_project()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $another_user->id]);

        $response = $this->patch("/project/{$project->id}", [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this Project record."));

        $this->assertDatabaseHas('project', [
            'name' => $project->name,
            'company_name' => $project->company_name,
            'tax_number' => $project->tax_number,
            'vat_number' => $project->vat_number,
            'address' => $project->address,
        ]);
    }
}
