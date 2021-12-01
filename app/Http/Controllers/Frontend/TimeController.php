<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Time\StoreTimeRequest;
use App\Http\Requests\Frontend\Time\EditTimeRequest;
use App\Http\Requests\Frontend\Time\UpdateTimeRequest;
use App\Http\Requests\Frontend\Time\ToggleBilledRequest;
use App\Http\Requests\Frontend\Time\BulkToggleBilledRequest;
use App\Http\Requests\Frontend\Time\DeleteTimeRequest;
use App\Http\Requests\Frontend\Time\DeleteTimesRequest;
use App\Services\ClientService;
use App\Services\ProjectService;
use App\Services\TimeService;
use App\Models\Time;
use Illuminate\Support\Facades\Auth;

/**
 * Class TimeController.
 */
class TimeController extends Controller
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var TimeService
     */
    protected $timeService;

    /**
     * TimeController constructor.
     *
     * @param  ClientService  $clientService
     * @param  ProjectService  $projectService
     * @param  TimeService  $timeService
     */
    public function __construct(ClientService $clientService, ProjectService $projectService, TimeService $timeService)
    {
        $this->clientService = $clientService;
        $this->projectService = $projectService;
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
        $last_time = auth()->user()->times()->orderBy('created_at', 'desc')->first();
        return view('frontend.time.create')
            ->withLastTime($last_time);
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
        $validated_request = $request->validated();
        if (isset($validated_request['new_client']) && $validated_request['new_client']) {
            $client = $this->clientService->store([
                'name' => $validated_request['client_name'],
                'company_name' => $validated_request['client_company_name'] ?? '',
                'tax_number' => $validated_request['client_tax_number'] ?? '',
                'vat_number' => $validated_request['client_vat_number'] ?? '',
                'address' => $validated_request['client_address'] ?? '',
                'bank_account' => $validated_request['client_bank_account'] ?? '',
            ]);
            $validated_request['project_client_id'] = $client->id;
        }
        if (isset($validated_request['new_project']) && $validated_request['new_project']) {
            $project = $this->projectService->store([
                'name' => $validated_request['project_name'],
                'client_id' => $validated_request['project_client_id'],
            ]);
            $validated_request['project_id'] = $project->id;
        }
        $result = $this->timeService->store($validated_request);
        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result
            ]);
        }

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time record was added.'));
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
        $validated_request = $request->validated();
        if (isset($validated_request['new_client']) && $validated_request['new_client']) {
            $client = $this->clientService->store([
                'name' => $validated_request['client_name'],
                'company_name' => $validated_request['client_company_name'] ?? '',
                'tax_number' => $validated_request['client_tax_number'] ?? '',
                'vat_number' => $validated_request['client_vat_number'] ?? '',
                'address' => $validated_request['client_address'] ?? '',
                'bank_account' => $validated_request['client_bank_account'] ?? '',
            ]);
            $validated_request['project_client_id'] = $client->id;
        }
        if (isset($validated_request['new_project']) && $validated_request['new_project']) {
            $project = $this->projectService->store([
                'name' => $validated_request['project_name'],
                'client_id' => $validated_request['project_client_id'],
            ]);
            $validated_request['project_id'] = $project->id;
        }
        $this->timeService->update($time, $validated_request);

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time record was successfully updated.'));
    }

    /**
     * @param  ToggleBilledRequest  $request
     * @param  Time  $time
     *
     * @return mixed
     * @throws \Exception
     */
    public function toggleBilled(ToggleBilledRequest $request, Time $time)
    {
        $data = $request->validated();
            
        $this->timeService->toggleBilled($time);

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time record was successfully updated.'));
    }

    /**
     * @param  BulkToggleBilledRequest  $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function bulkToggleBilled(BulkToggleBilledRequest $request)
    {
        $data = $request->validated();

        $times = json_decode($data['times']);

        foreach ($times as $time) {
            $time = Time::find($time);
            if (!is_null($time)) {
                $this->timeService->toggleBilled($time);
            }
        }

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time records were successfully deleted.'));
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

        return redirect()->back()->withFlashSuccess(__('The time record was successfully deleted.'));
    }

    /**
     * @param  DeleteTimesRequest  $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function bulkDestroy(DeleteTimesRequest $request)
    {
        $times = json_decode($request->validated()['times']);

        foreach ($times as $time) {
            $time = Time::find($time);
            if (!is_null($time)) {
                $this->timeService->destroy($time);
            }
        }

        return redirect()->route('frontend.time.index')->withFlashSuccess(__('The time records were successfully deleted.'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        return view('frontend.time.calendar');
    }
}