<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\CreatePorjectTaskRequest;

class ProjectController extends Controller
{
  protected $projectService;

  public function __construct(ProjectService $projectService)
  {
			$this->middleware('project-role-access:show')->only('show');
			$this->middleware('project-role-access:store')->only('store');
			$this->middleware('project-role-access:update')->only('update');
			$this->middleware('project-role-access:destroy')->only('destroy');
			$this->middleware('project-role-access:storeTask')->only('storeTask');
			$this->middleware('project-role-access:indexTasks')->only('indexTasks');
			$this->projectService = $projectService;
  }

	public function index(Request $request)
	{
		return $this->projectService->getProjects($request->user()->id);
	}

	public function store(CreateProjectRequest $request)
	{
		$user = $request->user();
    return $this->projectService->createProject($user->id, $request->validated());
	}

	public function update(CreateProjectRequest $request, $projectId)
	{
		return $this->projectService->updateProject($projectId, $request->validated());
	}


	public function destroy($id)
	{
		return $this->projectService->deleteProject($id);
	}

	public function show($id)
	{
		return $this->projectService->getProject($id);
	}

	public function storeTask(CreatePorjectTaskRequest $request, $projectId)
	{
		$authorId = $request->user()->id;

		return $this->projectService->createProjectTask($projectId, $authorId, $request->validated());
	}

	public function indexTasks($projectId)
	{
		return $this->projectService->getProjectTasks($projectId);
	}

}
