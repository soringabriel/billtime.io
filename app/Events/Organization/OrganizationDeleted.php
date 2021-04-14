<?php

namespace App\Events\Organization;

use App\Models\Organization;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrganizationDeleted.
 */
class OrganizationDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $organization;

    /**
     * @param $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }
}
