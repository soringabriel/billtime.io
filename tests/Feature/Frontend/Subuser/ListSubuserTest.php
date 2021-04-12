<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListSubuserTest.
 */
class ListSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_parent_user_can_see_his_subusers()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $this->get('/subuser')->assertOk();
    }
    
    /** @test */
    public function a_subuser_cant_see_the_subusers_page()
    {
        $user = User::factory()->user()->create();

        $subuser = User::factory()->user()->create(['parent_user_id' => $user->id]);

        $this->actingAs($subuser);

        $response = $this->get('/subuser');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
}
