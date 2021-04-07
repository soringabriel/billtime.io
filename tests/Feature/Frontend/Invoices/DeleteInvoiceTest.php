<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Events\Invoice\InvoiceDeleted;
use App\Models\Invoice;
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

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);

        $response = $this->delete("/invoices/{$invoice->id}");

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);

        Event::assertDispatched(InvoiceDeleted::class);
    }
    
    /** @test */
    public function a_user_cannot_delete_a_invoice_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);

        $this->delete("/invoices/{$invoice->id}");

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);
    }
}
