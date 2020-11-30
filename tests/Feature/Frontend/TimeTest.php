<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class TimeTest.
 */
class TimeTest extends TestCase
{
    /** @test */
    public function only_authenticated_users_can_access_their_account()
    {
        $this->get('/time')->assertRedirect('/login');

        $this->actingAs(User::factory()->user()->create());

        $this->get('/time')->assertOk();
    }
}
