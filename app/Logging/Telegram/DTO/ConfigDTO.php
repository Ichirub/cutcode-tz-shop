<?php

declare(strict_types=1);

namespace App\Logging\Telegram\DTO;

class ConfigDTO
{
    private int $level;
    private string $token;
    private int $chatId;

    public function __construct(array $config)
    {
        $this->level = (int)$config['level'];
        $this->token = $config['token'];
        $this->chatId = (int)$config['chat_id'];
    }

    public function level(): int
    {
        return $this->level;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function chatId(): int
    {
        return $this->chatId;
    }
}
