<?php

namespace App\Http\Controllers\Backend;

/**
 * Class FeedbacksController.
 */
class FeedbacksController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.feedback.index');
    }
}