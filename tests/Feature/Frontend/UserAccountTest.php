<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class UserAccountTest.
 */
class UserAccountTest extends TestCase
{
    /** @test */
    public function only_authenticated_users_can_access_their_account()
    {
        $this->get('/account')->assertRedirect('/login');

        $this->actingAs(User::factory()->create());

        $this->get('/account')->assertOk();
    }

    /** @test */
    public function profile_update_requires_validation()
    {
        $this->actingAs(User::factory()->create());

        config(['boilerplate.access.user.change_email' => true]);

        $response = $this->patch('/profile/update');

        $response->assertSessionHasErrors(['name', 'email']);

        config(['boilerplate.access.user.change_email' => false]);

        $response = $this->patch('/profile/update');

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_user_can_update_their_profile()
    {
        config(['boilerplate.access.user.change_email' => false]);

        $user = User::factory()->create([
            'name' => 'Jane Doe',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
        ]);

        $response = $this->actingAs($user)
            ->patch('/profile/update', [
                'name' => 'John Doe',
            ])->assertRedirect('/account?#information');

        $response->assertSessionHas('flash_success', __('Profile successfully updated.'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
        ]);
    }

    /** @test */
    public function a_user_can_update_their_email_address()
    {
        config(['boilerplate.access.user.change_email' => true]);

        $user = User::factory()->create([
            'email' => 'jane@doe.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'jane@doe.com',
        ]);

        $response = $this->actingAs($user)
            ->patch('/profile/update', [
                'name' => 'John Doe',
                'email' => 'john@doe.com',
            ])->assertRedirect('/email/verify');

        $response->assertSessionHas('resent');
        $response->assertSessionHas('flash_info', __('You must confirm your new e-mail address before you can go any further.'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'email_verified_at' => null,
        ]);

        // Double check
        $this->get('/account')->assertRedirect('/email/verify');
    }

    /** @test */
    public function a_user_can_update_their_company_details()
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'company_name' => $user->company_name,
            'tax_number' => $user->tax_number,
            'vat_number' => $user->vat_number,
            'address' => $user->address,
            'bank_name' => $user->bank_name,
            'bank_account' => $user->bank_account,
        ]);

        $response = $this->actingAs($user)
            ->patch('/profile/updateCompanyDetails', [
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
            'company_name' => 'company_name',
            'tax_number' => 'tax_number',
            'vat_number' => 'vat_number',
            'address' => 'address',
            'bank_name' => 'bank_name',
            'bank_account' => 'bank_account',
        ]);
    }

    /** @test */
    public function a_subuser_cannot_update_their_company_details()
    {
        $user = User::factory()->create(]);

        $subuser = User::factory()->create(['parent_user_id' => $user->id]);

        $response = $this->actingAs($subuser)
            ->patch('/profile/updateCompanyDetails', [
                'company_name' => 'company_name',
                'tax_number' => 'tax_number',
                'vat_number' => 'vat_number',
                'address' => 'address',
                'bank_name' => 'bank_name',
                'bank_account' => 'bank_account',
            ])->assertRedirect('/');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));

        $this->assertDatabaseHas('users', [
            'id' => $subuser->id,
            'company_name' => $subuser->company_name,
            'tax_number' => $subuser->tax_number,
            'vat_number' => $subuser->vat_number,
            'address' => $subuser->address,
            'bank_name' => $subuser->bank_name,
            'bank_account' => $subuser->bank_account,
        ]);
    }
}
