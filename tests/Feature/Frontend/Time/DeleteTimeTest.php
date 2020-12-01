<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeDeleted;
use App\Models\Time;
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
    public function a_Time_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $time = Time::factory()->create(['user_id' => $user->id]);

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

        $time = Time::factory()->create(['user_id' => $another_user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('time', ['id' => $time->id]);

        $this->delete("/time/{$time->id}");

        $this->assertDatabaseHas('time', ['id' => $time->id]);
    }
}
