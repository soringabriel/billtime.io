<?php

namespace Tests\Feature\Frontend\Invoice;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListInvoiceTest.
 */
class ListInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_list_of_the_invoices()
    {
        $user = User::factory()->user()->create();

        $this->get('/invoices')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/invoices')->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_list_of_the_invoices()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get('/invoices');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
}
