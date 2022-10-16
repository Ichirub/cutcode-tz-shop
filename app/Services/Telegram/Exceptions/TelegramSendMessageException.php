<?php

declare(strict_types=1);

namespace App\Services\Telegram\Exceptions;

use Exception;

class TelegramSendMessageException extends Exception
{
    /**
     * @param Exception $e
     * @return void
     * @throws TelegramSendMessageException
     */
    public static function throwException(Exception $e): void
    {
        throw new self(
            $e->getMessage(),
            $e->getCode(),
            $e->getPrevious()
        );
    }
}
