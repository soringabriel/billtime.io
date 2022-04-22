<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Schedule\StoreScheduleRequest;
use App\Http\Requests\Frontend\Schedule\EditScheduleRequest;
use App\Http\Requests\Frontend\Schedule\UpdateScheduleRequest;
use App\Http\Requests\Frontend\Schedule\DeleteScheduleRequest;
use App\Services\ScheduleService;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

/**
 * Class ScheduleController.
 */
class ScheduleController extends Controller
{
    /**
     * @var ScheduleService
     */
    protected $scheduleService;

    /**
     * ScheduleController constructor.
     *
     * @param  ScheduleService  $scheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.schedules.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.schedules.create');
    }

    /**
     * @param  StoreScheduleRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreScheduleRequest $request)
    {
        $result = $this->scheduleService->store($request->validated());

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.schedules.index')->withFlashSuccess(__('The schedule was added.'));
    }
    
    /**
     * @param  EditScheduleRequest  $request
     * @param  Schedule  $schedule
     *
     * @return mixed
     */
    public function edit(EditScheduleRequest $request, Schedule $schedule)
    {
        return view('frontend.schedules.edit')
            ->withSchedule($schedule);
    }

    /**
     * @param  UpdateScheduleRequest  $request
     * @param  Schedule  $schedule
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $result = $this->scheduleService->update($schedule, $request->validated());

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.schedules.index')->withFlashSuccess(__('The schedule was successfully updated.'));
    }

    /**
     * @param  DeleteScheduleRequest  $request
     * @param  Schedule  $schedule
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeleteScheduleRequest $request, Schedule $schedule)
    {
        $this->scheduleService->destroy($schedule);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('frontend.schedules.index')->withFlashSuccess(__('The schedule was successfully deleted.'));
    }

    /**
     * @return mixed
     */
    public function getSchedules()
    {
        $schedules = Schedule::query()->whereIn('user_id', auth()->user()->organization()->first()->users()->pluck('id')->toArray())->get();
        $result = [];
        foreach ($schedules as $schedule) {
            $result[] = $schedule->apiProperties();
        }
        return $result;
    }

    /**
     * @param  Schedule  $schedule
     *
     * @return mixed
     */
    public function get(Schedule $schedule)
    {
        return $schedule->apiProperties();
    }
}