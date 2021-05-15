<?php

namespace Tests\Feature\Backend\Plan;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListPlanTest.
 */
class ListPlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_plan_index_page()
    {
        $this->loginAsAdmin();

        $this->get('/admin/plan')->assertOk();
    }

    /** @test */
    public function only_admin_can_view_plans()
    {
        $this->actingAs(User::factory()->user()->create());

        $response = $this->get('/admin/plan');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
