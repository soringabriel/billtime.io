<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientDeleted;
use App\Models\Client;
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

        $client = Client::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $response = $this->delete("/clients/{$client->id}");

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);

        Event::assertDispatched(ClientDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_client_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $this->delete("/clients/{$client->id}");

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }
}
