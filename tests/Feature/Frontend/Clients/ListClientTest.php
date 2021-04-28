<?php

namespace Tests\Feature\Frontend\Client;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListClientTest.
 */
class ListClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_list_of_the_clients()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->get('/clients')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/clients')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
        ]);

        $this->get('/clients')->assertOk();
    }
}
