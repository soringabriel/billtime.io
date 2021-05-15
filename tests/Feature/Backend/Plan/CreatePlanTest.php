<?php

namespace Tests\Feature\Backend\Plan;

use App\Events\Plan\PlanCreated;
use App\Models\Plan;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreatePlanTest.
 */
class CreatePlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_create_plan_page()
    {
        $this->loginAsAdmin();

        $this->get('/admin/plan/create')->assertOk();
    }

    /** @test */
    public function create_plan_requires_validation()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/plan');

        $response->assertSessionHasErrors(['name', 'price', 'currency', 'billing_type', 'subusers_quota']);
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/plan', ['name' => Plan::first()->name]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_permissions_must_belong_to_the_type_user()
    {
        $this->loginAsAdmin();

        $permission = Permission::where('type', User::TYPE_ADMIN)->first();

        $response = $this->post('/admin/plan', [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 1,
            'permissions' => [
                $permission->id,
            ],
        ]);

        $response->assertSessionHasErrors('permissions.0');
    }

    /** @test */
    public function a_plan_can_be_created()
    {
        Event::fake();

        $this->loginAsAdmin();

        $permission = Permission::where('type', User::TYPE_USER)->first();

        $this->post('/admin/plan', [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 1,
            'permissions' => [
                $permission->id,
            ],
        ]);

        $this->assertDatabaseHas('plans', [
            'name' => 'new plan',
            'price' => 20,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 1,
        ]);

        $plan = Plan::where('name', 'new plan')->first();

        $this->assertDatabaseHas('model_has_permissions', [
            'permission_id' => $permission->id,
            'model_type' => 'App\Models\Plan',
            'model_id' => $plan->id,
        ]);
        
        Event::assertDispatched(PlanCreated::class);
    }

    /** @test */
    public function only_admin_can_create_plans()
    {
        $this->actingAs(User::factory()->user()->create());

        $response = $this->get('/admin/plan/create');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
