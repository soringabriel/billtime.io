<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Backend\Plan\StorePlanRequest;
use App\Http\Requests\Backend\Plan\EditPlanRequest;
use App\Http\Requests\Backend\Plan\UpdatePlanRequest;
use App\Http\Requests\Backend\Plan\DeletePlanRequest;
use App\Models\Plan;
use App\Domains\Auth\Models\User;
use App\Services\PlanService;
use App\Domains\Auth\Services\PermissionService;

/**
 * Class PlansController.
 */
class PlansController
{
    /**
     * @var PlanService
     */
    protected $planService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * PlansController constructor.
     *
     * @param  PlanService  $planService
     * @param  PermissionService  $permissionService
     */
    public function __construct(PlanService $planService, PermissionService $permissionService)
    {
        $this->planService = $planService;
        $this->permissionService = $permissionService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.plan.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('backend.plan.create')            
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions());
    }

    /**
     * @param  StorePlanRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StorePlanRequest $request)
    {
        $plan = $this->planService->store($request->validated());

        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The plan was successfully created.'));
    }

    /**
     * @param  EditPlanRequest  $request
     * @param  Plan  $plan
     *
     * @return mixed
     */
    public function edit(EditPlanRequest $request, Plan $plan)
    {
        return view('backend.plan.edit')
            ->withPlan($plan)
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions())
            ->withUsedPermissions($plan->permissions->modelKeys());
    }

    /**
     * @param  UpdatePlanRequest  $request
     * @param  Plan  $plan
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $this->planService->update($plan, $request->validated());

        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The plan was successfully updated.'));
    }

    /**
     * @param  DeletePlanRequest  $request
     * @param  Plan  $plan
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeletePlanRequest $request, Plan $plan)
    {
        $this->planService->destroy($plan);

        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The plan was successfully deleted.'));
    }
}