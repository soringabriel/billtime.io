<?php

namespace Tests\Feature\Frontend\Time;

use App\Domains\Auth\Models\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListTimeTest.
 */
class ListTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_list_of_the_times()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/time')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/time')->assertOk();
    }
}
