<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeUpdated;
use App\Models\Time;
use App\Models\Client;
use App\Models\Project;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class ToggleBilledTimeTest.
 */
class ToggleBilledTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_cannot_toggle_another_user_time()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);

        $project = Project::factory()->create(['user_id' => $another_user->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $response = $this->patch("/time/{$time->id}/toggleBilled");

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $time->project_id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => $time->billed,
        ]);
    }

    /** @test */
    public function a_non_billed_time_can_be_marked_as_billed()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $client = Client::factory()->create(['user_id' => $user->id]);

        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->patch("/time/{$time->id}/toggleBilled");

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $project->id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => 1,
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }

    /** @test */
    public function a_billed_time_can_be_marked_as_not_billed()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $client = Client::factory()->create(['user_id' => $user->id]);

        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id,
            'billed' => 1,
        ]);

        $this->patch("/time/{$time->id}/toggleBilled");

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'project_id' => $project->id,
            'task' => $time->task,
            'details' => $time->details,
            'billed' => 0,
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }
}
