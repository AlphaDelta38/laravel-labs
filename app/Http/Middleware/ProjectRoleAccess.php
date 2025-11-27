<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ProjectService;
use App\Exceptions\AppException;
use App\Enums\AccessRuleEnums;

class ProjectRoleAccess
{
    protected $projectService;
    protected $userAccess = [
        'show' => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
        'destroy' => [AccessRuleEnums::OWNER],
        'update' => [AccessRuleEnums::OWNER],
        "storeTask" => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
        "indexTasks" => [AccessRuleEnums::OWNER, AccessRuleEnums::MEMBER],
    ];

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        $user = $request->user();
        $project = $this->projectService->getProject($request->route('project'));
        $action = $params[0];

        $projectUsers = $project->project_users;
        $userAccess = [];

        if ($projectUsers->contains('user_id', $user->id)) {
            array_push($userAccess, AccessRuleEnums::MEMBER);
        } 
        
        if ($project->owner_id === $user->id) {
            array_push($userAccess, AccessRuleEnums::OWNER);
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
