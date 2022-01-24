<?php

namespace App\Events\Email;

use App\Models\Email;
use Illuminate\Queue\SerializesModels;

/**
 * Class EmailCreated.
 */
class EmailCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $email;

    /**
     * @param $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }
}
