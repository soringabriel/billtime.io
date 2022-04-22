<?php

namespace App\Events\Schedule;

use App\Models\Schedule;
use Illuminate\Queue\SerializesModels;

/**
 * Class ScheduleCreated.
 */
class ScheduleCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $schedule;

    /**
     * @param $schedule
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }
}
