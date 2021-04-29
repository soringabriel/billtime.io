<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
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

        $user = User::factory()->user()->create();
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $this->get('/time')->assertOk();
    }
}
