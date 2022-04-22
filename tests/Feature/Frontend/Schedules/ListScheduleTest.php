<?php

namespace Tests\Feature\Frontend\Schedule;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListScheduleTest.
 */
class ListScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_list_of_the_schedules()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/schedules')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/schedules')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.schedule')->first()->id,
        ]);

        $this->get('/schedules')->assertOk();
    }
}
