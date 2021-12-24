<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Client\StoreClientRequest;
use App\Http\Requests\Frontend\Client\EditClientRequest;
use App\Http\Requests\Frontend\Client\UpdateClientRequest;
use App\Http\Requests\Frontend\Client\DeleteClientRequest;
use App\Services\ClientService;
use App\Models\Client;

/**
 * Class ClientController.
 */
class ClientController extends Controller
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * ClientController constructor.
     *
     * @param  ClientService  $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.clients.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.clients.create');
    }

    /**
     * @param  StoreClientRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreClientRequest $request)
    {
        $result = $this->clientService->store($request->validated());

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.clients.index')->withFlashSuccess(__('The client was added.'));
    }
    
    /**
     * @param  EditClientRequest  $request
     * @param  Client  $client
     *
     * @return mixed
     */
    public function edit(EditClientRequest $request, Client $client)
    {
        return view('frontend.clients.edit')
            ->withClient($client);
    }

    /**
     * @param  UpdateClientRequest  $request
     * @param  Client  $client
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $result = $this->clientService->update($client, $request->validated());

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.clients.index')->withFlashSuccess(__('The client was successfully updated.'));
    }

    /**
     * @param  DeleteClientRequest  $request
     * @param  Client  $client
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeleteClientRequest $request, Client $client)
    {
        $this->clientService->destroy($client);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('frontend.clients.index')->withFlashSuccess(__('The client was successfully deleted.'));
    }

    /**
     * @return mixed
     */
    public function getClients()
    {
        $clients = Client::query()->where('organization_id', auth()->user()->organization()->first()->id);
        $result = [];
        foreach ($clients as $client) {
            $result[] = $client->apiProperties();
        }
        return $result;
    }

    /**
     * @param  Client  $client
     *
     * @return mixed
     */
    public function get(Client $client)
    {
        return $client->apiProperties();
    }
}