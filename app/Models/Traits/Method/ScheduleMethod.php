<?php

namespace App\Models\Traits\Method;

use App\Models\Schedule;
use Illuminate\Support\HtmlString;

/**
 * Trait ScheduleMethod.
 */
trait ScheduleMethod
{
    /**
     * @return array
     */
    public function apiProperties(): array
    {
        return [
            "id" => $this->id,
            "project_id" => $this->project_id,
            "period" => $this->period,
            "schedule_trigger" => $this->schedule_trigger,
            "price_per_hour" => $this->price_per_hour,
            "discount" => $this->discount,
            "tax" => $this->tax,
            "shipping" => $this->shipping,
            "service_fee" => $this->service_fee,
            "notes" => $this->notes,
        ];
    }
}
