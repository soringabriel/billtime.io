<?php

namespace Tests\Feature\Frontend\Client;

use App\Events\Client\ClientCreated;
use App\Domains\Auth\Models\User;
use App\Models\Client;
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
    public function only_an_user_can_access_the_create_a_client_page()
    {
        $user = User::factory()->user()->create();
        
        $this->get('/clients/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/clients/create')->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_create_client_page()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get('/clients/create');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function creating_a_client_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);
        
        $response = $this->post('/clients');

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_client_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();

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
