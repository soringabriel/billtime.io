<?php

namespace App\Events\Plan;

use App\Models\Plan;
use Illuminate\Queue\SerializesModels;

/**
 * Class PlanCreated.
 */
class PlanCreated
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
