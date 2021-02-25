<?php

namespace App\Services;

use App\Events\Client\ClientCreated;
use App\Events\Client\ClientDeleted;
use App\Events\Client\ClientUpdated;
use App\Models\Client;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ClientService.
 */
class ClientService extends BaseService
{
    /**
     * ClientService constructor.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->model = $client;
    }

    /**
     * @param  array  $data
     *
     * @return Client
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Client
    {
        DB::beginTransaction();

        try {
            $client = $this->model::create(
                [
                    'user_id' => auth()->id(),
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'tax_number' => $data['tax_number'],
                    'vat_number' => $data['vat_number'],
                    'address' => $data['address'],
                    'bank_account' => $data['bank_account'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Client.'));
        }

        event(new ClientCreated($client));

        DB::commit();

        return $client;
    }

    /**
     * @param  Client  $client
     * @param  array  $data
     *
     * @return Client
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Client $client, array $data = []): Client
    {
        DB::beginTransaction();

        try {
            $client->update(
                [
                    'user_id' => auth()->id(),
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'tax_number' => $data['tax_number'],
                    'vat_number' => $data['vat_number'],
                    'address' => $data['address'],
                    'bank_account' => $data['bank_account'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Client.'));
        }

        event(new ClientUpdated($client));

        DB::commit();

        return $client;
    }

    /**
     * @param  Client  $client
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Client $client): bool
    {
        if ($this->deleteById($client->id)) {
            event(new ClientDeleted($client));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Client.'));
    }
}