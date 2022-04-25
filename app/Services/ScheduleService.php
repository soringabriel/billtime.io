<?php

namespace App\Services;

use App\Events\Schedule\ScheduleCreated;
use App\Events\Schedule\ScheduleDeleted;
use App\Events\Schedule\ScheduleUpdated;
use App\Models\Schedule;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ScheduleService.
 */
class ScheduleService extends BaseService
{
    /**
     * ScheduleService constructor.
     *
     * @param  Schedule  $schedule
     */
    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }

    /**
     * @param  array  $data
     *
     * @return Schedule
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Schedule
    {
        DB::beginTransaction();

        try {
            $schedule = $this->model::create(
                [
                    'user_id' => auth()->id(),
                    'project_id' => $data['project_id'],
                    'schedule_trigger' => $data['schedule_trigger'],
                    'price_per_hour' => $data['price_per_hour'],
                    'price_currency' => $data['price_currency'],
                    'discount' => $data['discount'] ?? null,
                    'tax' => $data['tax'],
                    'shipping' => $data['shipping'] ?? null,
                    'service_fee' => $data['service_fee'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Schedule.'));
        }

        event(new ScheduleCreated($schedule));

        DB::commit();

        return $schedule;
    }

    /**
     * @param  Schedule  $schedule
     * @param  array  $data
     *
     * @return Schedule
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Schedule $schedule, array $data = []): Schedule
    {
        DB::beginTransaction();

        try {
            $schedule->update(
                [
                    'user_id' => auth()->id(),
                    'project_id' => $data['project_id'],
                    'schedule_trigger' => $data['schedule_trigger'],
                    'price_per_hour' => $data['price_per_hour'],
                    'price_currency' => $data['price_currency'],
                    'discount' => $data['discount'] ?? null,
                    'tax' => $data['tax'],
                    'shipping' => $data['shipping'] ?? null,
                    'service_fee' => $data['service_fee'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            exit();
            throw new GeneralException(__('There was a problem updating the Schedule.'));
        }

        event(new ScheduleUpdated($schedule));

        DB::commit();

        return $schedule;
    }

    /**
     * @param  Schedule  $schedule
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Schedule $schedule): bool
    {
        if ($this->deleteById($schedule->id)) {
            event(new ScheduleDeleted($schedule));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Schedule.'));
    }
}