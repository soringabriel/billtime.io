<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Organization;
use Tests\TestCase;

/**
 * Class OrganizationTest.
 */
class OrganizationTest extends TestCase
{
    /** @test */
    public function a_user_that_is_an_organization_owner_can_update_their_company_details()
    {
        $user = User::factory()->create(['name' => 'Jane Doe']);
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'organization_id' => $organization->id,
        ]);

        $this->assertDatabaseHas('organizations', [
            'company_name' => $organization->company_name,
            'tax_number' => $organization->tax_number,
            'vat_number' => $organization->vat_number,
            'address' => $organization->address,
            'bank_name' => $organization->bank_name,
            'bank_account' => $organization->bank_account,
        ]);

        $response = $this->actingAs($user)
            ->patch('/profile/updateOrganizationDetails', [
                'company_name' => 'company_name',
                'tax_number' => 'tax_number',
                'vat_number' => 'vat_number',
                'address' => 'address',
                'bank_name' => 'bank_name',
                'bank_account' => 'bank_account',
            ])->assertRedirect('/account?#information');

        $response->assertSessionHas('flash_success', __('Company details successfully updated.'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'organization_id' => $organization->id,
        ]);

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'company_name' => 'company_name',
            'tax_number' => 'tax_number',
            'vat_number' => 'vat_number',
            'address' => 'address',
            'bank_name' => 'bank_name',
            'bank_account' => 'bank_account',
        ]);
    }

    /** @test */
    public function a_user_that_is_not_the_organization_owner_cannot_update_their_company_details()
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->create(['organization_id' => $organization->id]);

        $response = $this->actingAs($subuser)
            ->patch('/profile/updateOrganizationDetails', [
                'company_name' => 'company_name',
                'tax_number' => 'tax_number',
                'vat_number' => 'vat_number',
                'address' => 'address',
                'bank_name' => 'bank_name',
                'bank_account' => 'bank_account',
            ])->assertRedirect('/');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));

        $this->assertDatabaseHas('organizations', [
            'company_name' => $organization->company_name,
            'tax_number' => $organization->tax_number,
            'vat_number' => $organization->vat_number,
            'address' => $organization->address,
            'bank_name' => $organization->bank_name,
            'bank_account' => $organization->bank_account,
        ]);
    }
}
