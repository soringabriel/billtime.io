<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;

/**
 * Class DeletedSubuserController.
 */
class DeletedSubuserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * DeletedSubuserController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.subuser.deleted');
    }

    /**
     * @param  User  $deletedUser
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(User $deletedUser)
    {
        $this->userService->restore($deletedUser);

        return redirect()->route('frontend.user.subuser.index')->withFlashSuccess(__('The user was successfully restored.'));
    }

    /**
     * @param  User  $deletedUser
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(User $deletedUser)
    {
        abort_unless(config('boilerplate.access.user.permanently_delete'), 404);

        $this->userService->destroy($deletedUser);

        return redirect()->route('frontend.user.subuser.deleted')->withFlashSuccess(__('The user was permanently deleted.'));
    }
}
