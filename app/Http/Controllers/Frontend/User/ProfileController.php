<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Services\UserService;
use App\Services\OrganizationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Frontend\User\UpdateOrganizationDetailsRequest;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $userService->updateProfile($request->user(), $request->validated());

        if (session()->has('resent')) {
            return redirect()->route('frontend.auth.verification.notice')->withFlashInfo(__('You must confirm your new e-mail address before you can go any further.'));
        }

        return redirect()->route('frontend.user.account', ['#information'])->withFlashSuccess(__('Profile successfully updated.'));
    }

    /**
     * @param  UpdateOrganizationDetailsRequest  $request
     * @param  OrganizationService  $organizationService
     *
     * @return mixed
     */
    public function updateOrganizationDetails(UpdateOrganizationDetailsRequest $request, OrganizationService $organizationService)
    {
        $payload = $request->validated();

        $payload['working_days'] = json_encode($payload['working_days']);

        $organizationService->update($request->user()->organization()->first(), $payload);

        return redirect()->route('frontend.user.account', ['#organization'])->withFlashSuccess(__('Company details successfully updated.'));
    }
}
