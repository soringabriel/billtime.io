<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Organization;
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
}
