<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectCreated;
use App\Domains\Auth\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateProjectTest.
 */
class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_create_a_project_page()
    {
        $user = User::factory()->user()->create();
        
        $this->get('/projects/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/projects/create')->assertOk();
    }

    /** @test */
    public function creating_a_project_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);
        
        $response = $this->post('/projects');

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_project_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $this->post('/projects', [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        Event::assertDispatched(ProjectCreated::class);
    }
}
