<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text)
    {
        Http::get(
            self::sendMessageUrl($token),
            ['chat_id' => $chatId, 'text' => $text]
        );
    }

    protected static function sendMessageUrl(string $token)
    {
        return self::buildBaseUrl($token) . '/sendMessage';
    }

    protected static function buildBaseUrl(string $token): string
    {
        return self::HOST . $token;
    }
}
