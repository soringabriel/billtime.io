<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateClientTest.
 */
class CreateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permission_can_access_the_create_a_client_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/clients/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/clients/create')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.create')->first()->id
        ]);

        $this->get('/clients/create')->assertOk();
    }

    /** @test */
    public function creating_a_client_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.create')->first()->id
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/clients');

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_client_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.create')->first()->id
        ]);

        $this->actingAs($user);

        $response = $this->post('/clients', [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
            'bank_account' => 'bank_account',
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
            'bank_account' => 'bank_account',
        ]);

        Event::assertDispatched(ClientCreated::class);
    }
}
