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
    public function plan()
    {
        $plans = Plan::all();
        $associated_array_plans = [];
        foreach ($plans as $plan) {
            $associated_array_plans[$plan->name] = $plan;
        }
        $organization = auth()->user()->organization()->first();
        return view('frontend.pages.plan')
            ->withOrganization($organization)
            ->withSubscription($organization->subscription('default'))
            ->withUserPlan($organization->plan()->first())
            ->withUserNextPlan($organization->nextPlan()->first())
            ->withAssociatedPlans($associated_array_plans);
    }
}
