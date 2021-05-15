<?php

namespace Tests\Feature\Backend\Plan;

use App\Events\Plan\PlanDeleted;
use App\Models\Plan;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeletePlanTest.
 */
class DeletePlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_plan_can_be_deleted()
    {
        Event::fake();

        $plan = Plan::factory()->create();

        $this->loginAsAdmin();

        $this->assertDatabaseHas('plans', ['id' => $plan->id]);

        $this->delete("/admin/plan/{$plan->id}");

        $this->assertDatabaseMissing('plans', ['id' => $plan->id]);

        Event::assertDispatched(PlanDeleted::class);
    }

    /** @test */
    public function only_admin_can_delete_plans()
    {
        $this->actingAs(User::factory()->user()->create());

        $plan = Plan::factory()->create();

        $response = $this->delete('/admin/plan/'.$plan->id);

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas('plans', ['id' => $plan->id]);
    }
}
