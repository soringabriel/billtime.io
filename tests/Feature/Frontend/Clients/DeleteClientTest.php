<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientDeleted;
use App\Models\Client;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
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
    public function a_client_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

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

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $this->delete("/clients/{$client->id}");

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }

    /** @test */
    public function a_subuser_cannot_delete_a_client()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->delete("/clients/{$client->id}");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
}
