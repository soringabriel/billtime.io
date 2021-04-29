<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Events\Invoice\InvoiceUpdated;
use App\Models\Time;
use App\Models\Project;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateInvoiceTest.
 */
class UpdateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_edit_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        
        $this->get("/invoices/{$invoice->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/invoices/{$invoice->id}/edit")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
        ]);

        $this->get("/invoices/{$invoice->id}/edit")->assertOk();
    }
    
    /** @test */
    public function an_subuser_with_permissions_can_access_the_edit_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $subuser = User::factory()->user()->create();
        $subuser->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        
        $this->get("/invoices/{$invoice->id}/edit")->assertRedirect('/login');

        $this->actingAs($subuser);

        $this->get("/invoices/{$invoice->id}/edit")->assertRedirect(route(homeRoute()));

        $subuser->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.edit-all')->first()->id, 
        ]);

        $this->get("/invoices/{$invoice->id}/edit")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_invoice_page_for_other_organization_users_invoices()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);
        
        $this->get("/invoices/{$invoice->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_invoice_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $response = $this->patch("/invoices/{$invoice->id}");

        $response->assertSessionHasErrors(['number', 'buyer_company_name', 'seller_company_name', 'services', 'tax', 'currency', 'price', 'date']);
    }

    /** @test */
    public function a_invoice_cannot_be_associated_to_times_that_dont_belong_to_the_user_organization_when_updating()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $time = Time::factory()->create([
            'user_id' => $another_user->id, 
            'project_id' => $project->id
        ]);

        $response = $this->patch("/invoices/{$invoice->id}", [
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

        $this->assertDatabaseHas('invoices', [
            'number' => $invoice->number,
            'buyer_company_name' => $invoice->buyer_company_name,
            'seller_company_name' => $invoice->seller_company_name,
            'seller_bank_account' => $invoice->seller_bank_account,
            'services' => $invoice->services,
            'tax' => $invoice->tax,
            'currency' => $invoice->currency,
            'price' => $invoice->price,
            'date' => $invoice->date,
            'due_date' => $invoice->due_date,
        ]);
    }

    /** @test */
    public function a_invoice_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $this->patch("/invoices/{$invoice->id}", [
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

        Event::assertDispatched(InvoiceUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_user_invoice()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.edit-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $response = $this->patch("/invoices/{$invoice->id}", [
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

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('invoices', [
            'number' => $invoice->number,
            'buyer_company_name' => $invoice->buyer_company_name,
            'seller_company_name' => $invoice->seller_company_name,
            'seller_bank_account' => $invoice->seller_bank_account,
            'services' => $invoice->services,
            'tax' => $invoice->tax,
            'currency' => $invoice->currency,
            'price' => $invoice->price,
            'date' => $invoice->date,
            'due_date' => $invoice->due_date,
        ]);
    }
    
    /** @test */
    public function a_invoice_status_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PAID,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PAID,
        ]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PENDING,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PENDING,
        ]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PAST_DUE,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PAST_DUE,
        ]);

        Event::assertDispatched(InvoiceUpdated::class);
    }
   
    /** @test */
    public function a_invoice_status_can_be_updated_by_a_subuser_with_permissions()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $subuser = User::factory()->user()->create();
        $subuser->update(['organization_id' => $organization->id]);
        $subuser->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.update-status-all')->first()->id, 
        ]);

        $this->actingAs($subuser);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PAID,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PAID,
        ]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PENDING,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PENDING,
        ]);

        $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PAST_DUE,
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $user->id,
            'status' => Invoice::STATUS_PAST_DUE,
        ]);

        Event::assertDispatched(InvoiceUpdated::class);
    }
        
    /** @test */
    public function a_user_cannot_update_the_invoice_status_of_another_users_invoice()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.update-status-all')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $response = $this->patch("/invoices/{$invoice->id}/updateStatus", [
            'status' => Invoice::STATUS_PAID,
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'user_id' => $another_user->id,
            'status' => $invoice->status,
        ]);
    }
}
