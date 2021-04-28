<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListSubuserTest.
 */
class ListSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_with_permissions_can_see_subusers()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->get('/subuser')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
        ]);

        $this->get('/subuser')->assertOk();
    }
}
