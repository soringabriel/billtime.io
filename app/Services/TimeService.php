<?php

namespace App\Services;

use App\Events\Time\TimeCreated;
use App\Events\Time\TimeDeleted;
use App\Events\Time\TimeUpdated;
use App\Models\Time;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TimeService.
 */
class TimeService extends BaseService
{
    /**
     * TimeService constructor.
     *
     * @param  Time  $time
     */
    public function __construct(Time $time)
    {
        $this->model = $time;
    }

    /**
     * @param  array  $data
     *
     * @return Time
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Time
    {
        DB::beginTransaction();

        try {
            $time = $this->model::create(
                [
                    'user_id' => auth()->id(),
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'project_id' => $data['project_id'],
                    'task' => $data['task'],
                    'details' => $data['details'],
                ]
            );
            $time->tags()->sync($data['tags'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Time record.'));
        }

        event(new TimeCreated($time));

        DB::commit();

        return $time;
    }

    /**
     * @param  Time  $time
     * @param  array  $data
     *
     * @return Time
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Time $time, array $data = []): Time
    {
        DB::beginTransaction();

        try {
            $time->update(
                [
                    'user_id' => auth()->id(),
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'project_id' => $data['project_id'],
                    'task' => $data['task'],
                    'details' => $data['details'],
                ]
            );
            $time->tags()->sync($data['tags'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Time record.'));
        }

        event(new TimeUpdated($time));

        DB::commit();

        return $time;
    }

    /**
     * @param  Time  $time
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Time $time): bool
    {
        if ($this->deleteById($time->id)) {
            event(new TimeDeleted($time));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Time record.'));
    }

    /**
     * @param  Time  $time
     * @param  array  $data
     *
     * @return Time
     * @throws GeneralException
     * @throws \Throwable
     */
    public function markAsBilled(Time $time): Time
    {
        DB::beginTransaction();

        try {
            $time->update(
                [
                    'billed' => true,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Time record.'));
        }

        event(new TimeUpdated($time));

        DB::commit();

        return $time;
    }
}