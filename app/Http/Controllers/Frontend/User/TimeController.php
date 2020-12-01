<?php

namespace App\Http\Controllers\Frontend\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Time\StoreTimeRequest;
use App\Http\Requests\Frontend\Time\EditTimeRequest;
use App\Http\Requests\Frontend\Time\UpdateTimeRequest;
use App\Http\Requests\Frontend\Time\DeleteTimeRequest;
use App\Services\TimeService;
use App\Models\Time;

/**
 * Class TimeController.
 */
class TimeController extends Controller
{
    /**
     * @var TimeService
     */
    protected $timeService;

    /**
     * TimeController constructor.
     *
     * @param  TimeService  $timeService
     */
    public function __construct(TimeService $timeService)
    {
        $this->timeService = $timeService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.time.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.time.create');
    }

    /**
     * @param  StoreTimeRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreTimeRequest $request)
    {
        $this->timeService->store($request->validated());

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time was added.'));
    }
    
    /**
     * @param  EditTimeRequest  $request
     * @param  Time  $time
     *
     * @return mixed
     */
    public function edit(EditTimeRequest $request, Time $time)
    {
        return view('frontend.time.edit')
            ->withTime($time);
    }

    /**
     * @param  UpdateTimeRequest  $request
     * @param  Time  $time
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateTimeRequest $request, Time $time)
    {
        $this->timeService->update($time, $request->validated());

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time was successfully updated.'));
    }

    /**
     * @param  DeleteTimeRequest  $request
     * @param  Time  $time
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeleteTimeRequest $request, Time $time)
    {
        $this->timeService->destroy($time);

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time was successfully deleted.'));
    }
}