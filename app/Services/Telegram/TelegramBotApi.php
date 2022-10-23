<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramSendMessageException;
use Illuminate\Support\Facades\Http;
use Throwable;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::acceptJson()
                ->throw()
                ->get(
                    self::getSendMessageUrl($token),
                    ['chat_id' => $chatId, 'text' => $text]
                );

            return $response->successful();
        } catch (Throwable $e) {
            report(TelegramSendMessageException::newException($e));

            return false;
        }
    }

    protected static function getSendMessageUrl(string $token): string
    {
        return self::HOST . $token . '/sendMessage';
    }
}
