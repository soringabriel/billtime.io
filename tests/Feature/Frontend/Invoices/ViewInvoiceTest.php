<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Domains\Auth\Models\User;
use App\Models\Invoice;
use App\Models\Organization;
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
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $invoice = Invoice::factory()->create(['user_id' => $user->id]);

        $response = $this->get("/invoices/{$invoice->id}/download");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cannot_view_another_users_invoice()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $invoice = Invoice::factory()->create(['user_id' => $another_user->id]);

        $response = $this->get("/invoices/{$invoice->id}/download");

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));
    }
}
