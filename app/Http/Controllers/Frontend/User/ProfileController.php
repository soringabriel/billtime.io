<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Frontend\User\UpdateCompanyDetailsRequest;

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
     * @param  UpdateCompanyDetailsRequest  $request
     * @param  UserService  $userService
     *
     * @return mixed
     */
    public function updateCompanyDetails(UpdateCompanyDetailsRequest $request, UserService $userService)
    {
        $userService->updateCompanyDetails($request->user(), $request->validated());

        return redirect()->route('frontend.user.account', ['#information'])->withFlashSuccess(__('Company details successfully updated.'));
    }
}
