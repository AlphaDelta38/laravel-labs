<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TaskService;
use App\Exceptions\AppException;
use App\Enums\AccessRuleEnums;

class TaskRoleAccess
{
    protected $taskService;

    protected $userAccess = [
        'show' => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
        'destroy' => [AccessRuleEnums::OWNER, AccessRuleEnums::AUTHOR],
        'update' => [AccessRuleEnums::OWNER, AccessRuleEnums::AUTHOR],
        "storeComment" => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
        "indexComments" => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
    ];

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        $user = $request->user();
        $task = $this->taskService->getTask($request->route('task'));

        $project = $task->project;
        $projectUsers = $project->project_users;
        
        $action = $params[0];
        $userAccess = [];

        if ($projectUsers->contains('user_id', $user->id)) {
            array_push($userAccess, AccessRuleEnums::MEMBER);
        } 
        
        if ($project->owner_id === $user->id) {
            array_push($userAccess, AccessRuleEnums::OWNER);
        }

        if ($task->author_id === $user->id) {
            array_push($userAccess, AccessRuleEnums::AUTHOR);
        }

        return $this->checkUserAccess($request, $next, $userAccess, $action);
    }

    private function checkUserAccess(Request $request, Closure $next, $accessRule, $action) {
        foreach ($accessRule as $rule) {
            if (in_array($rule, $this->userAccess[$action])) {
                return $next($request);
            }
        }

        throw new AppException('You are not authorized to ' . $action . ' this project', 403);
    }


}
