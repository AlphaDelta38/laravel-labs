<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\TaskCreated;

class Task extends Model
{
    use HasFactory;
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    protected $fillable = [
        "project_id",
        "author_id",
        "assignee_id",
        "title",
        "description",
        "status",
        "priority",
        "due_date",
        "created_at",
        "updated_at",
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    protected $dispatchesEvents = [
        'created' => TaskCreated::class,
    ];

}
