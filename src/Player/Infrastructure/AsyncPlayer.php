<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Kernel;
use App\Player\Application\Player\AsyncPlayerInterface;
use App\Player\Application\Player\Player;
use App\Player\Application\Player\Status\PlayerStatus;
use Symfony\Component\Process\Process;

class AsyncPlayer implements AsyncPlayerInterface
{
    private const PID_FILE = 'player.pid';

    private string $projectDir;

    public function __construct(
        Kernel $kernel,
        private Player $player
    ) {
        $this->projectDir = $kernel->getProjectDir();
    }

    public function playAudioAsync(string $audioId): void
    {
        $this->executePlayCommandAsync(['play-audio', $audioId]);
    }

    private function executePlayCommandAsync(array $args): void
    {
        $this->stop();

        $process = new Process(['php', "{$this->projectDir}/bin/console", 'app:player', ...$args]);
        $process->setOptions(['create_new_console' => true]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        $process->start();

        $this->saveProcessPid($process->getPid());
    }

    public function stop(): void
    {
        $pid = $this->getActiveProcessPid();
        if (null !== $pid) {
            shell_exec("kill {$pid}");
        }
        $this->player->stop();
    }

    private function getActiveProcessPid(): ?int
    {
        if (file_exists(self::PID_FILE)) {
            return (int) file_get_contents(self::PID_FILE);
        }

        return null;
    }

    private function saveProcessPid(int $pid): void
    {
        file_put_contents(self::PID_FILE, $pid);
    }

    public function playAlbumAsync(string $albumId): void
    {
        $this->executePlayCommandAsync(['play-album', $albumId]);
    }

    public function getStatus(): PlayerStatus
    {
        return $this->player->getStatus();
    }
}
