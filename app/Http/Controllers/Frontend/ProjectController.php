<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Project\StoreProjectRequest;
use App\Http\Requests\Frontend\Project\EditProjectRequest;
use App\Http\Requests\Frontend\Project\UpdateProjectRequest;
use App\Http\Requests\Frontend\Project\DeleteProjectRequest;
use App\Services\ProjectService;
use App\Models\Project;

/**
 * Class ProjectController.
 */
class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * ProjectController constructor.
     *
     * @param  ProjectService  $projectService
     */
    public function __construct(ProjectService $projectService)
    {
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
        $this->projectService->store($request->validated());

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
        $this->projectService->update($project, $request->validated());

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

        return redirect()->route('frontend.projects.index')->withFlashSuccess(__('The project was successfully deleted.'));
    }
}