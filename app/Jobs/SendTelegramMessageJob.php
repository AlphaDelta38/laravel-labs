<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $chatId;

    public function __construct(string $message, ?string $chatId = null)
    {
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function handle(TelegramService $telegramService): void
    {
        $telegramService->sendMessage($this->message, $this->chatId);
        Log::info("Sending Telegram message:   " . $this->message, ['chat_id' => $this->chatId]);
    }
}
