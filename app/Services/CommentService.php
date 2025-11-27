<?php

namespace App\Services;

use App\Models\Comment;
use App\Exceptions\AppException;

class CommentService {

  public function getComment(int $commentId) {
    $comment = Comment::where('id', $commentId)->first();

    if (!$comment) {
      throw new AppException('Comment not found', 404);
    }

    return $comment;
  }

  public function deleteComment(int $commentId) {
    $comment = $this->getComment($commentId);
    $comment->delete();
    return true;
  }
  
}