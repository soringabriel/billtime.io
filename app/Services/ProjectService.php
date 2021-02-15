<?php

namespace App\Services;

use App\Events\Project\ProjectCreated;
use App\Events\Project\ProjectDeleted;
use App\Events\Project\ProjectUpdated;
use App\Models\Project;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProjectService.
 */
class ProjectService extends BaseService
{
    /**
     * ProjectService constructor.
     *
     * @param  Project  $project
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    /**
     * @param  array  $data
     *
     * @return Project
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Project
    {
        DB::beginTransaction();

        try {
            $project = $this->model::create(
                [
                    'user_id' => auth()->id(),
                    'client_id' => $data['client_id'],
                    'name' => $data['name'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            echo 'Name is ' . $data['name'];
            throw new GeneralException($e->getMessage() . __('There was a problem creating the Project.'));
        }

        event(new ProjectCreated($project));

        DB::commit();

        return $project;
    }

    /**
     * @param  Project  $project
     * @param  array  $data
     *
     * @return Project
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Project $project, array $data = []): Project
    {
        DB::beginTransaction();

        try {
            $project->update(
                [
                    'user_id' => auth()->id(),
                    'client_id' => $data['client_id'],
                    'name' => $data['name'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Project.'));
        }

        event(new ProjectUpdated($project));

        DB::commit();

        return $project;
    }

    /**
     * @param  Project  $project
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Project $project): bool
    {
        if ($this->deleteById($project->id)) {
            event(new ProjectDeleted($project));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Project.'));
    }
}