<?php

namespace App\Events\Client;

use App\Models\Client;
use Illuminate\Queue\SerializesModels;

/**
 * Class ClientDeleted.
 */
class ClientDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $client;

    /**
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
