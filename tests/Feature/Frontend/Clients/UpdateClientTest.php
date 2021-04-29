<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientUpdated;
use App\Models\Client;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateClientTest.
 */
class UpdateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_edit_a_client_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);
        
        $this->get("/clients/{$client->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/clients/{$client->id}/edit")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.edit')->first()->id
        ]);

        $this->get("/clients/{$client->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_client_page_for_other_organizations_clients()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.edit')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);
        
        $this->get("/clients/{$client->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_client_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.edit')->first()->id
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $response = $this->patch("/clients/{$client->id}");

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_client_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.edit')->first()->id
        ]);

        $this->actingAs($user);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->patch("/clients/{$client->id}", [
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

        Event::assertDispatched(ClientUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_organization_client()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.clients.access')->first()->id, 
            Permission::where('name', 'user.access.clients.edit')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $response = $this->patch("/clients/{$client->id}", [
            'name' => 'name',
            'company_name' => 'company',
            'tax_number' => 'tax',
            'vat_number' => 'vat',
            'address' => 'address',
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('clients', [
            'name' => $client->name,
            'company_name' => $client->company_name,
            'tax_number' => $client->tax_number,
            'vat_number' => $client->vat_number,
            'address' => $client->address,
        ]);
    }
}
