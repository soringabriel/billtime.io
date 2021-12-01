<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Events\Invoice\InvoiceCreated;
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
 * Class CloneInvoiceTest.
 */
class CloneInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_clone_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        
        $this->get("/invoices/{$invoice->id}/clone")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/invoices/{$invoice->id}/clone")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.create')->first()->id, 
        ]);

        $this->get("/invoices/{$invoice->id}/clone")->assertOk();
    }
    
    /** @test */
    public function an_subuser_with_permissions_can_access_the_clone_a_invoice_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $subuser = User::factory()->user()->create();
        $subuser->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        
        $this->get("/invoices/{$invoice->id}/clone")->assertRedirect('/login');

        $this->actingAs($subuser);

        $this->get("/invoices/{$invoice->id}/clone")->assertRedirect(route(homeRoute()));

        $subuser->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.show-all')->first()->id, 
            Permission::where('name', 'user.access.invoices.create')->first()->id, 
        ]);

        $this->get("/invoices/{$invoice->id}/clone")->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_clone_invoice_page_for_other_organization_users_invoices()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.invoices.access')->first()->id, 
            Permission::where('name', 'user.access.invoices.show-all')->first()->id, 
            Permission::where('name', 'user.access.invoices.create')->first()->id, 
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);
        
        $this->get("/invoices/{$invoice->id}/clone")->assertRedirect(route(homeRoute()));
    }
}
