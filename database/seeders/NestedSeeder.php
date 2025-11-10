<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;

class NestedSeeder extends Seeder
{
	protected $roles = ['owner', 'admin', 'user'];

	public function run(): void
	{
		$users = User::factory()->count(5)->create();

		$users->each(function ($user) use ($users) {
			$projects = Project::factory()->count(2)->for($user, 'owner')->create();

			$projects->each(function ($project) use ($users, $user) {
				$members = $users->random(2);

				foreach ($members as $member) {
					$project->project_users()->attach($member->id, ['role' => Arr::random($this->roles)]);

					$tasks = Task::factory()
						->count(2)
						->for($project, 'project')
						->for($member, 'assignee')
						->for($user, 'author')
						->create();

					$tasks->each(function ($task) use ($member) {
						Comment::factory()
							->count(2)
							->for($member, 'author')
							->for($task, 'task')
							->create();
					});
				}
			});
		});
	}
}
