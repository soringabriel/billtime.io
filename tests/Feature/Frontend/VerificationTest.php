<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class VerificationTest.
 */
class VerificationTest extends TestCase
{
    /** @test */
    public function an_unverified_user_cannot_access_dashboard()
    {
        $user = User::factory()->unconfirmed()->create();
        $user->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id, 
        ]);

        $this->actingAs($user);

        $this->get('/time')->assertRedirect('/email/verify');
    }

    /** @test */
    public function an_unverified_user_cannot_access_account()
    {
        $user = User::factory()->unconfirmed()->create();

        $this->actingAs($user);

        $this->get('/account')->assertRedirect('/email/verify');
    }

    /** @test */
    public function a_user_can_resend_the_verification_email()
    {
        Notification::fake();

        $user = User::factory()->unconfirmed()->create();

        $this->actingAs($user);

        $this->get('/account')->assertRedirect('/email/verify');

        $this->post('/email/resend');

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
