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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reports()
    {
        $time_charts_data = auth()->user()->organization()->first()->getTimesChartData();
        $charts = [
            [
                'html_id' => 'organizationTimePerDay',
                'labels' => array_keys($time_charts_data['daily']),
                'values' => array_values($time_charts_data['daily']),
                'charts_js_opts' => [
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'borderColor' => 'rgb(153, 102, 255)'
                ]
            ],
            [
                'html_id' => 'organizationTimePerMonth',
                'labels' => array_keys($time_charts_data['monthly']),
                'values' => array_values($time_charts_data['monthly']),
                'charts_js_opts' => [
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ]
                ]
            ]
        ];

        return view('frontend.pages.reports')
            ->withOrganization(auth()->user()->organization()->first())
            ->withCharts($charts);
    }
}
