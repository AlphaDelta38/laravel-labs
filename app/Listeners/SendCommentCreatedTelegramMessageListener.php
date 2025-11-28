<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendTelegramMessageJob;
use Illuminate\Support\Facades\Log;

class SendCommentCreatedTelegramMessageListener
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
    public function handle(CommentCreated $event): void
    {
        $message = "New comment created: " . $event->comment->body . " by " . $event->comment->author->name . " for task " . $event->comment->task->title . " at " . $event->comment->created_at;
        Log::info("Sending Telegram message:   " . $message);
        SendTelegramMessageJob::dispatch($message);
    }
}
