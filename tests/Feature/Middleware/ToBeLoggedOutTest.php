<?php

namespace Tests\Feature\Middleware;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class ToBeLoggedOutTest.
 */
class ToBeLoggedOutTest extends TestCase
{
    /** @test */
    public function the_user_can_be_forced_logged_out()
    {
        $user = User::factory()->user()->create(['to_be_logged_out' => false]);

        $this->actingAs($user);

        $this->get('/time')->assertOk();

        $user->update(['to_be_logged_out' => true]);

        $this->get('/time')->assertRedirect('/login');

        $this->assertFalse($this->isAuthenticated());
    }
}
