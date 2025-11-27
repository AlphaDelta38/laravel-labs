<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Comment;
use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    public function getTask(int $taskId)
    {
      $task = Task::where('id', $taskId)->first();

      if (!$task) {
        throw new AppException('Task not found', 404);
      }

      return $task;
    }

    public function deleteTask(int $taskId)
    {
      $task = $this->getTask($taskId);
      $task->delete();
      return true;
    }

    public function updateTask(int $taskId, array $data)
    {
      $task = $this->getTask($taskId);
      $task->update($data);
      return $task;
    }

    public function getTaskComments(int $taskId) {
      $task = $this->getTask($taskId);
      return $task->comments;
    }

    public function createTaskComment(int $taskId, $authorId, array $data) {
      $task = $this->getTask($taskId);
      $comment = $task->comments()->create([...$data, 'author_id' => $authorId, 'task_id' => $taskId]);
      return $comment;
    }
}