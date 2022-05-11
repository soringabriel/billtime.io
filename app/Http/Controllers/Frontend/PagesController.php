<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;

/**
 * Class PagesController.
 */
class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('frontend.pages.dashboard')
            ->withOrganization(auth()->user()->organization()->first())
            ->withTimesChartData(auth()->user()->getTimesChartData())
            ->withOrganizationTimesChartData(auth()->user()->organization()->first()->getTimesChartData());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function analytics()
    {
        return view('frontend.pages.analytics')
            ->withOrganization(auth()->user()->organization()->first())
            ->withTimesChartData(auth()->user()->getTimesChartData())
            ->withOrganizationTimesChartData(auth()->user()->organization()->first()->getTimesChartData());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function plan()
    {
        $plans = Plan::all();
        $associated_array_plans = [];
        foreach ($plans as $plan) {
            $associated_array_plans[$plan->name] = $plan;
        }
        $organization = auth()->user()->organization()->first();
        $updateUrl = null;
        if ($organization->subscribed('default') && !$organization->subscription('default')->cancelled()) {
            $updateUrl = $organization->subscription('default')->updateUrl();
        }
        $organization_plan = $organization->plan()->first();
        $cancelUrl = null;
        if ($organization->subscribed('default') && !$organization->subscription('default')->cancelled()) {
            $cancelUrl = route('frontend.subscription.cancel-subscription');
        }
        $organization_next_plan = $organization->nextPlan()->first();
        $nextPayment = null;
        if (!$organization_next_plan->isDefault() && $organization->subscribed('default')) {
            $nextPayment = $organization->subscription('default')->nextPayment();
        }

        return view('frontend.pages.plan')
            ->withOrganization($organization)
            ->withSubscription($organization->subscription('default'))
            ->withUpdateUrl($updateUrl)
            ->withCancelUrl($cancelUrl)
            ->withNextPayment($nextPayment)
            ->withUserPlan($organization_plan)
            ->withUserNextPlan($organization->nextPlan()->first())
            ->withAssociatedPlans($associated_array_plans);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function receipts()
    {
        return view('frontend.pages.receipts');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function api()
    {
        return view('frontend.api.index');
    }
}
