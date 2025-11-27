<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{

    public function getProjects($userId)
    {
      return Project::where('owner_id', $userId)->get();
    }

    public function getProject(int $id)
    {
      $project = Project::where('id', $id)->first();
      
      if (!$project) {
          throw new AppException('Project not found', 404);
      }

      return $project;
    }

    public function createProject($ownerId, array $data)
    {
        $project = Project::create([
          ...$data,
          "owner_id" => $ownerId
        ]);
        return $project;
    }


    public function updateProject($id, array $data)
    {
        $project = $this->getProject($id);
        $project->update($data);

        return $project;
    }

    public function deleteProject($id)
    {
        $project = $this->getProject($id);
        $project->delete();

        return true;
    }

    public function createProjectTask($projectId, $authorId, array $data){
      $project = $this->getProject($projectId);

      $task = $project->tasks()->create([...$data, 'author_id' => $authorId, 'project_id' => $projectId]);
      
      return $task;
    }

    public function getProjectTasks($projectId) {
      $project = $this->getProject($projectId);
      return $project->tasks;
    }

}
