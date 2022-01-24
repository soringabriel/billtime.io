<?php

namespace App\Services;

use App\Events\Email\EmailCreated;
use App\Events\Email\EmailDeleted;
use App\Events\Email\EmailUpdated;
use App\Models\Email;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EmailService.
 */
class EmailService extends BaseService
{
    /**
     * EmailService constructor.
     *
     * @param  Email  $email
     */
    public function __construct(Email $email)
    {
        $this->model = $email;
    }

    /**
     * @param  array  $data
     *
     * @return Email
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Email
    {
        DB::beginTransaction();

        try {
            $email = $this->model::create(
                [
                    'invoice_id' => $data['invoice_id'],
                    'from' => $data['from'],
                    'to' => $data['to'],
                    'locale' => $data['locale'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Email.'));
        }

        event(new EmailCreated($email));

        DB::commit();

        return $email;
    }
}