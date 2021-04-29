<?php

namespace App\Events\Organization;

use App\Models\Organization;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrganizationCreated.
 */
class OrganizationCreated
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
