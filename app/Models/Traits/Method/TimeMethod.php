<?php

namespace App\Models\Traits\Method;

use App\Models\Time;
use Illuminate\Support\HtmlString;

/**
 * Trait TimeMethod.
 */
trait TimeMethod
{
    /**
     * @return array
     */
    public function apiProperties(): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "start_time" => $this->start_time,
            "end_time"=> $this->end_time,
            "project_id"=> $this->project_id,
            "task"=> $this->task,
            "details"=> $this->details,
            "billed"=> $this->billed,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
