<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Kernel;
use App\Player\Application\Player\AsyncPlayerInterface;
use App\Player\Application\Player\Player;
use App\Player\Infrastructure\OSProcess\OSProcessManager;


class AsyncPlayer implements AsyncPlayerInterface
{
    private const PID_FILE = 'player.pid';

    private string $projectDir;

    public function __construct(
        Kernel                  $kernel,
        private Player          $player,
        private OSProcessManager $processManager
    )
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    public function playQueueAsync(): void
    {
        $this->executePlayCommandAsync(['play-main-playlist']);
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
        if (null !== $pid) {
            $this->processManager->kill($pid);
        }
        $this->player->stop();
    }

    private function getActiveProcessPid(): ?int
    {
        if (file_exists(self::PID_FILE)) {
            return (int)file_get_contents(self::PID_FILE);
        }

        return null;
    }

    private function saveProcessPid(int $pid): void
    {
        file_put_contents(self::PID_FILE, $pid);
    }
}
