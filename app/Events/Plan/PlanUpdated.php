<?php

namespace App\Events\Plan;

use App\Models\Plan;
use Illuminate\Queue\SerializesModels;

/**
 * Class PlanUpdated.
 */
class PlanUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $plan;

    /**
     * @param $plan
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }
}
