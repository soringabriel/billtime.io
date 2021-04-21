<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Events\Invoice\InvoiceDeleted;
use App\Models\Invoice;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteInvoiceTest.
 */
class DeleteInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_invoice_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);

        $response = $this->delete("/invoices/{$invoice->id}");

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);

        Event::assertDispatched(InvoiceDeleted::class);
    }

    /** @test */
    public function a_subuser_cannot_delete_a_invoice()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->delete("/invoices/{$invoice->id}");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cannot_delete_a_invoice_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);

        $this->delete("/invoices/{$invoice->id}");

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);
    }
}
