<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeUpdated;
use App\Models\Time;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateTimeTest.
 */
class UpdateTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_edit_a_time_page()
    {
        $user = User::factory()->user()->create();

        $time = Time::factory()->create(['user_id' => $user->id]);
        
        $this->get("/time/{$time->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/time/{$time->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_time_page_for_other_users_times()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $time = Time::factory()->create(['user_id' => $another_user->id]);
        
        $this->get("/time/{$time->id}/edit")->assertRedirect('/time');
    }

    /** @test */
    public function updating_a_time_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $time = Time::factory()->create(['user_id' => $user->id]);

        $response = $this->patch("/time/{$time->id}");

        $response->assertSessionHasErrors(['start_time', 'end_time', 'details']);
    }

    /** @test */
    public function a_time_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $time = Time::factory()->create(['user_id' => $user->id]);

        $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00:00',
            'end_time' => '2020-12-01 01:00:00',
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00:00',
            'end_time' => '2020-12-01 01:00:00',
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_user_time()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $time = Time::factory()->create(['user_id' => $another_user->id]);

        $response = $this->patch("/time/{$time->id}", [
            'start_time' => '2020-12-01 00:00:00',
            'end_time' => '2020-12-01 01:00:00',
            'task' => 'task',
            'details' => 'details',
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this Time record."));

        $this->assertDatabaseHas('time', [
            'start_time' => $time->start_time,
            'end_time' => $time->end_time,
            'task' => $time->task,
            'details' => $time->details,
        ]);
    }
}
