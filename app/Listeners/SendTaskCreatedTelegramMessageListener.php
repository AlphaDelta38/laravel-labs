<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendTelegramMessageJob;
use Illuminate\Support\Facades\Log;

class SendTaskCreatedTelegramMessageListener
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreated $event): void
    {
        $message = "New task created: " . $event->task->title . " by " . $event->task->author->name . " for project " . $event->task->project->name . " at " . $event->task->created_at;
        Log::info("Sending Telegram message:   " . $message);
        SendTelegramMessageJob::dispatch($message);
    }
}
