<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;

use App\Http\Requests\Project\CreatePorjectTaskRequest;
use App\Http\Requests\Task\CreateTaskCommentRequest;

class TasksController extends Controller
{
  protected $taskService;

  public function __construct(TaskService $taskService)
  {
			$this->middleware('task-role-access:update')->only('update');
			$this->middleware('task-role-access:destroy')->only('destroy');
			$this->middleware('task-role-access:show')->only('show');
			$this->middleware('task-role-access:storeComment')->only('storeComment');
			$this->middleware('task-role-access:indexComments')->only('indexComments');
      $this->taskService = $taskService;
  }

	public function update(CreatePorjectTaskRequest $request, $taskId)
	{
		return $this->taskService->updateTask($taskId, $request->validated());
	}

	public function destroy($id)
	{
		return $this->taskService->deleteTask($id);
	}

	public function show($id)
	{
		return $this->taskService->getTask($id);
	}

	public function storeComment(CreateTaskCommentRequest $request, $taskId)
	{
		$authorId = $request->user()->id;

		return $this->taskService->createTaskComment($taskId, $authorId, $request->validated());
	}

	public function indexComments($taskId)
	{
		return $this->taskService->getTaskComments($taskId);
	}

}
