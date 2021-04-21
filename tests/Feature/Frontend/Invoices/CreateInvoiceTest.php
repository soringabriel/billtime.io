<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Events\Invoice\InvoiceCreated;
use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Project;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateInvoiceTest.
 */
class CreateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_create_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/invoices/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/invoices/create')->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_create_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->get("/invoices/create");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function creating_a_invoice_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);
        
        $response = $this->post('/invoices');

        $response->assertSessionHasErrors(['number', 'buyer_company_name', 'seller_company_name', 'seller_bank_account', 'services', 'tax', 'currency', 'price', 'date']);
    }

    /** @test */
    public function a_invoice_cannot_be_associated_to_times_that_dont_belong_to_the_user()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $response = $this->post('/invoices', [
            'number' => 'abcd',
            'buyer_company_name' => 'test',
            'seller_company_name' => 'test2',
            'seller_bank_account' => 'bank_account',
            'services' => json_encode([
                [
                    'name' => 'service1',
                    'units' => 'hours',
                    'quantity' => 1,
                    'price' => 1,
                    'discount' => 0,
                    'total' => 1,
                ]
            ]),
            'tax' => 0,
            'currency' => 'USD',
            'price' => 1,
            'date' => '2021-04-04',
            'due_date' => '2021-08-20',
            'times' => json_encode([$time->id]),
        ]);

        $response->assertSessionHasErrors(['times']);

        $this->assertDatabaseMissing('invoices', [
            'user_id' => $user->id,
            'number' => 'abcd',
            'buyer_company_name' => 'test',
            'seller_company_name' => 'test2',
            'seller_bank_account' => 'bank_account',
            'services' => json_encode([
                [
                    'name' => 'service1',
                    'units' => 'hours',
                    'quantity' => 1,
                    'price' => 1,
                    'discount' => 0,
                    'total' => 1,
                ]
            ]),
            'tax' => 0,
            'currency' => 'USD',
            'price' => 1,
            'date' => '2021-04-04',
            'due_date' => '2021-08-20',
            'times' => json_encode([$time->id]),
        ]);
    }

    /** @test */
    public function a_invoice_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $response = $this->post('/invoices', [
            'number' => 'abcd',
            'buyer_company_name' => 'test',
            'seller_company_name' => 'test2',
            'seller_bank_account' => 'bank_account',
            'services' => json_encode([
                [
                    'name' => 'service1',
                    'units' => 'hours',
                    'quantity' => 1,
                    'price' => 1,
                    'discount' => 0,
                    'total' => 1,
                ]
            ]),
            'tax' => 0,
            'currency' => 'USD',
            'price' => 1,
            'date' => '2021-04-04',
            'due_date' => '2021-08-20',
        ]);

        $this->assertDatabaseHas('invoices', [
            'user_id' => $user->id,
            'number' => 'abcd',
            'buyer_company_name' => 'test',
            'seller_company_name' => 'test2',
            'seller_bank_account' => 'bank_account',
            'services' => json_encode([
                [
                    'name' => 'service1',
                    'units' => 'hours',
                    'quantity' => 1,
                    'price' => 1,
                    'discount' => 0,
                    'total' => 1,
                ]
            ]),
            'tax' => 0,
            'currency' => 'USD',
            'price' => 1,
            'date' => '2021-04-04',
            'due_date' => '2021-08-20',
        ]);

        Event::assertDispatched(InvoiceCreated::class);
    }
}
