<?php

namespace Tests\Feature\Frontend\Client;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListClientTest.
 */
class ListClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_list_of_the_clients()
    {
        $user = User::factory()->user()->create();

        $this->get('/clients')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/clients')->assertOk();
    }
}
