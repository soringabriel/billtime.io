<?php

namespace App\Events\Organization;

use App\Models\Organization;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrganizationUpdated.
 */
class OrganizationUpdated
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
