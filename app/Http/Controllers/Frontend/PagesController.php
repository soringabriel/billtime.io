<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

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
}
