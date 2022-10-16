<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Logging\Telegram\DTO\ConfigDTO;
use App\Logging\Telegram\DTO\RecordDTO;
use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    private ConfigDTO $config;

    public function __construct(array $config)
    {
        $this->config = new ConfigDTO($config);
        $level = Logger::toMonologLevel($this->config->level());

        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        $record = new RecordDTO($record);
        $message = $this->formattedMessage($record);

        TelegramBotApi::sendMessage(
            $this->config->token(),
            $this->config->chatId(),
            $message
        );
    }

    protected function formattedMessage(RecordDTO $record): string
    {
        return '[' . $record->dateTime()->format('d.m.Y H:i:s') . "]\n"
            . $record->channel() . '.' . $record->levelName() . ":\n"
            . $record->message();
    }
}
