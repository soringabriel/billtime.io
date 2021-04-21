<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Requests\Frontend\User\DeleteSubuserRequest;
use App\Http\Requests\Frontend\User\EditSubuserRequest;
use App\Http\Requests\Frontend\User\StoreSubuserRequest;
use App\Http\Requests\Frontend\User\UpdateSubuserRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;

/**
 * Class SubuserController.
 */
class SubuserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * SubuserController constructor.
     *
     * @param  UserService  $userService
     * @param  RoleService  $roleService
     * @param  PermissionService  $permissionService
     */
    public function __construct(UserService $userService, RoleService $roleService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.subuser.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.user.subuser.create')
            ->withRoles($this->roleService->get())
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions());
    }

    /**
     * @param  StoreSubuserRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreSubuserRequest $request)
    {
        $data = $request->validated();

        $data['type'] = User::TYPE_USER;
        $data['organization_id'] = auth()->user()->organization()->first()->id;
        $data['send_confirmation_email'] = '1';
        $data['active'] = '1';

        $user = $this->userService->store($data);

        return redirect()->route('frontend.user.subuser.show', $user)->withFlashSuccess(__('The user was successfully created.'));
    }

    /**
     * @param  User  $user
     *
     * @return mixed
     */
    public function show(User $user)
    {
        return view('frontend.user.subuser.show')
            ->withUser($user);
    }

    /**
     * @param  EditSubuserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     */
    public function edit(EditSubuserRequest $request, User $user)
    {
        return view('frontend.user.subuser.edit')
            ->withUser($user)
            ->withRoles($this->roleService->get())
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions())
            ->withUsedPermissions($user->permissions->modelKeys());
    }

    /**
     * @param  UpdateSubuserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     * @throws \Throwable
     */
    public function update(UpdateSubuserRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('frontend.user.subuser.show', $user)->withFlashSuccess(__('The user was successfully updated.'));
    }

    /**
     * @param  DeleteSubuserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(DeleteSubuserRequest $request, User $user)
    {
        $this->userService->delete($user);

        return redirect()->route('frontend.user.subuser.deleted')->withFlashSuccess(__('The user was successfully deleted.'));
    }
}
