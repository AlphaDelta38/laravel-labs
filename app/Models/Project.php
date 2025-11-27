<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Task;
use App\Models\User;

class Project extends Model
{

	use HasFactory;
	/** @use HasFactory<\Database\Factories\ProjectFactory> */
	protected $fillable = [
        'owner_id',
        'name',
    ];

  public function owner()
  {
      return $this->belongsTo(User::class, 'owner_id');
  }

	public function tasks()
	{
		return $this->hasMany(Task::class, 'project_id');
	}
	
	public function project_users()
	{
		return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
	}

}
