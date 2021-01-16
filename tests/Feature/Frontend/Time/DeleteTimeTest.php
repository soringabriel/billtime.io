<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeDeleted;
use App\Models\Time;
use App\Models\Project;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteTimeTest.
 */
class DeleteTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_time_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseMissing('time', ['id' => $time->id]);

        Event::assertDispatched(TimeDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_time_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseHas('time', ['id' => $time->id]);
    }
        
    /** @test */
    public function multiple_times_can_be_deleted_in_bulk()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $time = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $time2 = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);

        $result = $this->delete("/time", [
            'times' => json_encode([$time->id, $time2->id]),
        ]);

        $this->assertDatabaseMissing('time', ['id' => $time->id]);

        $this->assertDatabaseMissing('time', ['id' => $time2->id]);

        Event::assertDispatched(TimeDeleted::class);
    }

        
    /** @test */
    public function a_user_cannot_delete_in_bulk_a_time_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $time2 = Time::factory()->create([
            'user_id' => $user->id, 
            'project_id' => $project->id
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);

        $this->delete("/time", [
            'times' => [
                $time->id,
                $time2->id,
            ],
        ]);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->assertDatabaseHas('time', ['id' => $time2->id]);
    }
}
