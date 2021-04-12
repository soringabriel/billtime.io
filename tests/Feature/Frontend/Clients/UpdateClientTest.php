<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientUpdated;
use App\Models\Client;
use App\Domains\Auth\Models\User;
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
    public function only_an_user_can_access_the_edit_a_client_page()
    {
        $user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $user->id]);
        
        $this->get("/clients/{$client->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/clients/{$client->id}/edit")->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_edit_a_client_page()
    {
        $user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $user->id]);

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get("/clients/{$client->id}/edit");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cannot_access_edit_client_page_for_other_users_clients()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);
        
        $this->get("/clients/{$client->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_client_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $client = Client::factory()->create(['user_id' => $user->id]);

        $response = $this->patch("/clients/{$client->id}");

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_client_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $client = Client::factory()->create(['user_id' => $user->id]);

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
    public function a_user_cannot_update_another_user_client()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);

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
