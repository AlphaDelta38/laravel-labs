<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{

    use HasFactory;
/** @use HasFactory<\Database\Factories\TasqkFactory> */
    protected $fillable = [
        "task_id",
        "author_id",
        "body",
        "created_at",
        "updated_at",
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

}
