<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Project\StoreProjectRequest;
use App\Http\Requests\Frontend\Project\EditProjectRequest;
use App\Http\Requests\Frontend\Project\UpdateProjectRequest;
use App\Http\Requests\Frontend\Project\DeleteProjectRequest;
use App\Services\ClientService;
use App\Services\ProjectService;
use App\Models\Project;

/**
 * Class ProjectController.
 */
class ProjectController extends Controller
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * ProjectController constructor.
     *
     * @param  ClientService  $clientService
     * @param  ProjectService  $projectService
     */
    public function __construct(ClientService $clientService, ProjectService $projectService)
    {
        $this->clientService = $clientService;
        $this->projectService = $projectService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.projects.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.projects.create');
    }

    /**
     * @param  StoreProjectRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreProjectRequest $request)
    {
        $validated_request = $request->validated();
        if (isset($validated_request['new_client']) && $validated_request['new_client']) {
            $client = $this->clientService->store([
                'name' => $validated_request['client_name'],
                'company_name' => $validated_request['client_company_name'] ?? '',
                'tax_number' => $validated_request['client_tax_number'] ?? '',
                'vat_number' => $validated_request['client_vat_number'] ?? '',
                'address' => $validated_request['client_address'] ?? '',
                'bank_account' => $validated_request['client_bank_account'] ?? '',
            ]);
            $validated_request['client_id'] = $client->id;
        }

        $result = $this->projectService->store($validated_request);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.projects.index')->withFlashSuccess(__('The project was added.'));
    }
    
    /**
     * @param  EditProjectRequest  $request
     * @param  Project  $project
     *
     * @return mixed
     */
    public function edit(EditProjectRequest $request, Project $project)
    {
        return view('frontend.projects.edit')
            ->withProject($project);
    }

    /**
     * @param  UpdateProjectRequest  $request
     * @param  Project  $project
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated_request = $request->validated();
        if (isset($validated_request['new_client']) && $validated_request['new_client']) {
            $client = $this->clientService->store([
                'name' => $validated_request['client_name'],
                'company_name' => $validated_request['client_company_name'] ?? '',
                'tax_number' => $validated_request['client_tax_number'] ?? '',
                'vat_number' => $validated_request['client_vat_number'] ?? '',
                'address' => $validated_request['client_address'] ?? '',
                'bank_account' => $validated_request['client_bank_account'] ?? '',
            ]);
            $validated_request['client_id'] = $client->id;
        }

        $result = $this->projectService->update($project, $validated_request);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

        return redirect()->route('frontend.projects.index')->withFlashSuccess(__('The project was successfully updated.'));
    }

    /**
     * @param  DeleteProjectRequest  $request
     * @param  Project  $project
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeleteProjectRequest $request, Project $project)
    {
        $this->projectService->destroy($project);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('frontend.projects.index')->withFlashSuccess(__('The project was successfully deleted.'));
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        $projects = Project::query()->where('organization_id', auth()->user()->organization()->first()->id);
        $result = [];
        foreach ($projects as $project) {
            $result[] = $project->apiProperties();
        }
        return $result;
    }

    /**
     * @param  Project  $project
     *
     * @return mixed
     */
    public function get(Project $project)
    {
        return $project->apiProperties();
    }
}