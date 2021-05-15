<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Organization;
use App\Models\Plan;
use Tests\TestCase;

/**
 * Class PagesTest.
 */
class PagesTest extends TestCase
{
    /** @test */
    public function the_dashboard_page_can_be_accesed_only_by_logged_in_users()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/dashboard')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/dashboard')->assertOk();
    }

    /** @test */
    public function the_plan_page_can_be_accesed_only_by_the_organization_owner()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create([
            'owner_id' => $user->id,
            'plan_id' => Plan::orderBy('price', 'desc')->first()->id,
            'next_plan_id' => Plan::orderBy('price', 'desc')->first()->id,
        ]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/plan')->assertRedirect('/login');

        $another_user = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($another_user);

        $this->get('/plan')->assertSessionHas('flash_danger', __("You don't have access to this page."));

        $this->actingAs($user);

        $this->get('/plan')->assertOk();
    }

    /** @test */
    public function the_receipts_page_can_be_accesed_only_by_the_organization_owner()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/receipts')->assertRedirect('/login');

        $another_user = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($another_user);

        $this->get('/receipts')->assertSessionHas('flash_danger', __("You don't have access to this page."));

        $this->actingAs($user);

        $this->get('/receipts')->assertOk();
    }
}
