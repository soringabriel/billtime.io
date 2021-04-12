<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Domains\Auth\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ViewInvoiceTest.
 */
class ViewInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_subuser_cannot_view_the_invoices()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $response = $this->get("/invoices/{$invoice->id}/download");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cannot_view_another_users_invoice()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $response = $this->get("/invoices/{$invoice->id}/download");

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));
    }
}
