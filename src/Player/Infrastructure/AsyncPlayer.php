<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Album\Domain\Album;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerInterface;
use App\Player\Application\Player\SyncPlayer;
use Symfony\Component\Filesystem\Filesystem;


class AsyncPlayer implements PlayerInterface
{
    private string $pidFilePath;

    public function __construct(
        private readonly string           $projectDir,
        private readonly SyncPlayer       $player,
        private readonly OSProcessManager $processManager,
        private readonly Filesystem       $filesystem
    )
    {
        $this->pidFilePath = $this->projectDir . '/player.pid';
    }

    public function playAudio(AudioReadModel $audio): void
    {
        $this->executePlayCommandAsync(['play-audio', $audio->id]);
    }

    public function playQueue(): void
    {
        $this->executePlayCommandAsync(['play-queue']);
    }


    public function playAlbum(Album $album): void
    {
        $this->executePlayCommandAsync(['play-album', $album->name]);
    }

    public function stop(): void
    {
        $pid = $this->getActiveProcessPid();
        if (null === $pid) {
            return;
        }
        $this->processManager->kill($pid);
        $this->player->stop();
        $this->filesystem->remove($this->pidFilePath);
    }


    private function executePlayCommandAsync(array $args): void
    {
        $this->stop();
        $pid = $this->processManager->runAsync(['php', "{$this->projectDir}/bin/console", 'app:player', ...$args]);
        $this->saveProcessPid($pid);
    }

    private function getActiveProcessPid(): ?int
    {
        if ($this->filesystem->exists($this->pidFilePath)) {
            return (int)file_get_contents($this->pidFilePath);
        }

        return null;
    }

    private function saveProcessPid(int $pid): void
    {
        $this->filesystem->appendToFile($this->pidFilePath, $pid);
    }
}
