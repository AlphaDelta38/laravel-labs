<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
  protected $commentService;

  public function __construct(CommentService $commentService)
  {
      $this->middleware('comment-role-access:delete')->only('destroy');
      $this->commentService = $commentService;
  }

	public function destroy($commentId)
	{
		return $this->commentService->deleteComment($commentId);
	}

}
