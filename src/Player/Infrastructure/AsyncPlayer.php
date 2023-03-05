<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\Player\AsyncPlayerInterface;
use App\Player\Application\Player\Player;
use App\Player\Infrastructure\OSProcess\OSProcessManager;


class AsyncPlayer implements AsyncPlayerInterface
{
    private string $pidFilePath;


    public function __construct(
        private readonly string           $projectDir,
        private readonly Player           $player,
        private readonly OSProcessManager $processManager
    )
    {
        $this->pidFilePath = $this->projectDir . '/player.pid';
    }

    public function playQueueAsync(): void
    {
        $this->executePlayCommandAsync(['play-queue']);
    }


    public function playAudioAsync(string $audioId): void
    {
        $this->executePlayCommandAsync(['play-audio', $audioId]);
    }

    private function executePlayCommandAsync(array $args): void
    {
        $this->stop();
        $pid = $this->processManager->runAsync(['php', "{$this->projectDir}/bin/console", 'app:player', ...$args]);
        $this->saveProcessPid($pid);
    }

    public function stop(): void
    {
        $pid = $this->getActiveProcessPid();
        if (null === $pid) {
            return;
        }
        $this->processManager->kill($pid);
        $this->player->stop();
        unlink($this->pidFilePath);
    }

    private function getActiveProcessPid(): ?int
    {
        if (file_exists($this->pidFilePath)) {
            return (int)file_get_contents($this->pidFilePath);
        }

        return null;
    }

    private function saveProcessPid(int $pid): void
    {
        file_put_contents($this->pidFilePath, $pid);
    }
}
