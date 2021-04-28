<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientDeleted;
use App\Models\Client;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteClientTest.
 */
class DeleteClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_client_can_be_deleted_only_by_a_user_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $this->delete("/clients/{$client->id}")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.delete')->first()->id
        ]);

        $response = $this->delete("/clients/{$client->id}");

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);

        Event::assertDispatched(ClientDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_client_that_belongs_to_another_organization()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.create')->first()->id
        ]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $this->delete("/clients/{$client->id}");

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }
}
