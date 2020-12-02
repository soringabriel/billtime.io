<?php

namespace App\Events\Project;

use App\Models\Project;
use Illuminate\Queue\SerializesModels;

/**
 * Class ProjectUpdated.
 */
class ProjectUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $project;

    /**
     * @param $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
