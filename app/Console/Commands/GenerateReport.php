<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Report;
use Carbon\Carbon;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate report for the project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projects = Project::with('tasks')->get();
        $reportData = [];

        foreach ($projects as $project) {
            $statusesCount = [
                "todo" => 0,
                "in_progress" => 0,
                "done" => 0,
                "expired" => 0,
            ];

            foreach ($project->tasks as $task) {
                if ($task->status != 'todo' && Carbon::parse($task->due_date)->isPast()) {
                    $statusesCount['expired']++;
                } else {
                    $statusesCount[$task->status]++;
                }
            }

            $reportData[$project->id] = [
                'project_name' => $project->name,
                ...$statusesCount,
            ];
        }
        
        $fromDate = Carbon::now()->startOfMonth();
        $toDate = Carbon::now()->endOfMonth();

        $path = 'reports/report_' . $fromDate . "-". $toDate . '.json';

        Report::create([
            'payload' => json_encode($reportData),
            'period_start' => $fromDate,
            'period_end' => $toDate,
            'path' => $path,
        ]);

        \Storage::put($path, json_encode($reportData, JSON_PRETTY_PRINT));

        $this->info('It was generated successfully');

    }
}
