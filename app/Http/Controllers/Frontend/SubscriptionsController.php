<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\OrganizationService;

/**
 * Class SubscriptionsController.
 */
class SubscriptionsController extends Controller
{
    /**
     * @var OrganizationService
     */
    protected $organizationService;

    /**
     * SubscriptionsController constructor.
     *
     * @param  OrganizationService  $organizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoices()
    {
        return view('frontend.subscription.invoices');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmation()
    {
        return view('frontend.subscription.confirmation');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSubscription(Plan $plan)
    {
        $original_plan = auth()->user()->organization()->first()->plan()->first();

        $this->organizationService->switchPlan(auth()->user()->organization()->first(), $plan);

        $route = $plan->price > $original_plan->price ? 'frontend.subscription.confirmation' : 'frontend.plan';

        return redirect()->route($route)->withFlashSuccess(__('Your subscriptions was updated.'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancelSubscription()
    {
        $this->organizationService->cancelSubscription(auth()->user()->organization()->first());

        return redirect()->route('frontend.plan')->withFlashSuccess(__('Your subscriptions was cancelled.'));
    }
}
