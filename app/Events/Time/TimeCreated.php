<?php

namespace App\Events\Time;

use App\Models\Time;
use Illuminate\Queue\SerializesModels;

/**
 * Class TimeCreated.
 */
class TimeCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $time;

    /**
     * @param $time
     */
    public function __construct(Time $time)
    {
        $this->time = $time;
    }
}
