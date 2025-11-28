<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    public function sendMessage(string $message, ?string $chatId = null): bool
    {
        $chatId = $chatId ?? config('services.telegram.chat_id');

        try {
            $response = Http::post($this->baseUrl . 'sendMessage', [
                'chat_id' => $chatId,
                'text'    => $message,
            ]);

            if ($response->successful()) {
                Log::info('Telegram Message Sent:', ['chat_id' => $chatId, 'text' => $message]);
                return true;
            } else {
                Log::error('Telegram API Error:', $response->json());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Telegram Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}