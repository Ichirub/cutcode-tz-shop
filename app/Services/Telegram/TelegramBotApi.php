<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramSendMessageException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text)
    {
        try {
            $response = Http::acceptJson()->get(
                self::sendMessageUrl($token),
                ['chat_id' => $chatId, 'text' => $text]
            );

            return $response->successful();
        } catch (\Exception $e) {
            TelegramSendMessageException::throwException($e);
        }
    }

    protected static function sendMessageUrl(string $token): string
    {
        return self::buildBaseUrl($token) . '/sendMessage';
    }

    protected static function buildBaseUrl(string $token): string
    {
        return self::HOST . $token;
    }
}
