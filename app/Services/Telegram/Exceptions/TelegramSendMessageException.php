<?php

declare(strict_types=1);

namespace App\Services\Telegram\Exceptions;

use Exception;
use Throwable;

class TelegramSendMessageException extends Exception
{
    public static function newException(Throwable $e): self
    {
        return new self(
            $e->getMessage(),
            $e->getCode(),
            $e->getPrevious()
        );
    }
}
