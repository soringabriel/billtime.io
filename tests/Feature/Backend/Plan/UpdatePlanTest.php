<?php

namespace Tests\Feature\Backend\Plan;

use App\Events\Plan\PlanUpdated;
use App\Models\Plan;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdatePlanTest.
 */
class UpdatePlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_name_is_required()
    {
        $plan = Plan::factory()->create();

        $this->loginAsAdmin();

        $response = $this->patch("/admin/plan/{$plan->id}");

        $response->assertSessionHasErrors(['name', 'price', 'currency', 'subusers_quota']);
    }

    /** @test */
    public function updating_a_plan_requires_name_to_be_unique()
    {
        $plan = Plan::factory()->create();
        $another_plan = Plan::factory()->create();

        $this->loginAsAdmin();

        $response = $this->patch("/admin/plan/{$plan->id}", [
            'name' => $another_plan->name,
            'price' => 20,
            'currency' => 'USD',
            'subusers_quota' => 1,
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_plan_cannot_be_updated_to_have_admin_permissions()
    {
        $plan = Plan::factory()->create();

        $permission = Permission::where('type', User::TYPE_ADMIN)->first();

        $this->loginAsAdmin();

        $response = $this->patch("/admin/plan/{$plan->id}", [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'subusers_quota' => 1,
            'permissions' => [
                $permission->id,
            ],
        ]);

        $response->assertSessionHasErrors('permissions.0');
    }

    /** @test */
    public function a_plan_can_be_updated()
    {
        Event::fake();

        $plan = Plan::factory()->create();

        $permission = Permission::where('type', User::TYPE_USER)->first();

        $this->loginAsAdmin();

        $response = $this->patch("/admin/plan/{$plan->id}", [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'subusers_quota' => 1,
            'permissions' => [
                $permission->id,
            ],
        ]);

        $this->assertDatabaseHas('plans', [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'billing_type' => $plan->billing_type,
            'subusers_quota' => 1,
        ]);

        $plan = Plan::where('name', 'new plan')->first();

        $this->assertDatabaseHas('model_has_permissions', [
            'permission_id' => $permission->id,
            'model_type' => 'App\Models\Plan',
            'model_id' => $plan->id,
        ]);

        Event::assertDispatched(PlanUpdated::class);
    }

    /** @test */
    public function only_admin_can_edit_plans()
    {
        $this->loginAsAdmin();

        $plan = Plan::factory()->create(['name' => 'current name']);

        $this->get("/admin/plan/{$plan->id}/edit")->assertOk();
    }

    /** @test */
    public function a_non_admin_can_not_edit_plans()
    {
        $this->actingAs(User::factory()->user()->create());

        $plan = Plan::factory()->create(['name' => 'current name']);

        $response = $this->get("/admin/plan/{$plan->id}/edit");

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }

    /** @test */
    public function only_admin_can_update_plans()
    {
        $this->actingAs(User::factory()->user()->create());

        $plan = Plan::factory()->create(['name' => 'current name']);

        $response = $this->patch("/admin/plan/{$plan->id}", [
            'name' => 'new name',
        ]);

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas('plans', [
            'id' => $plan->id,
            'name' => 'current name',
        ]);
    }
}
