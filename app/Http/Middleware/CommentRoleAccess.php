<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CommentService;
use App\Exceptions\AppException;
use App\Enums\AccessRuleEnums;

class CommentRoleAccess
{
    protected $commentService;

    protected $userAccess = [
      'destroy' => [AccessRuleEnums::OWNER, AccessRuleEnums::AUTHOR],
    ];

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        $user = $request->user();
        $comment = $this->commentService->getComment($request->route('comment'));

        $task = $comment->task;
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

        if ($comment->author_id === $user->id) {
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
