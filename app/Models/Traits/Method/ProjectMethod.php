<?php

namespace App\Models\Traits\Method;

use App\Models\Project;
use Illuminate\Support\HtmlString;

/**
 * Trait ProjectMethod.
 */
trait ProjectMethod
{
    /**
     * @return array
     */
    public function apiProperties(): array
    {
        return [
            "id" => $this->id,
            "client_id"=> $this->client_id,
            "name" => $this->name,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
