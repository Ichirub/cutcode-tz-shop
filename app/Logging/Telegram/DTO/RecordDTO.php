<?php

declare(strict_types=1);

namespace App\Logging\Telegram\DTO;

use Monolog\DateTimeImmutable;

class RecordDTO
{
    private string $message;
    private array $context;
    private int $level;
    private string $levelName;
    private string $channel;
    private DateTimeImmutable $dateTime;
    private array $extra;
    private string $formatted;

    public function __construct(array $record)
    {
        $this->message = $record['message'];
        $this->context = $record['context'];
        $this->level = (int)$record['level'];
        $this->levelName = $record['level_name'];
        $this->channel = $record['channel'];
        $this->dateTime = $record['datetime'];
        $this->extra = $record['extra'];
        $this->formatted = $record['formatted'];
    }

    public function message(): string
    {
        return $this->message;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function levelName(): string
    {
        return $this->levelName;
    }

    public function channel(): string
    {
        return $this->channel;
    }

    public function dateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function extra(): array
    {
        return $this->extra;
    }

    public function formatted(): string
    {
        return $this->formatted;
    }
}
