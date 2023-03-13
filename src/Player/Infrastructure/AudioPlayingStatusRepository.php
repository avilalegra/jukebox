<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Player\Status\CurrentPlayingAudioStatus;
use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;


class AudioPlayingStatusRepository implements AudioPlayingStatusRepositoryInterface
{
    private string $statusFilePath;

    public function __construct(
        private readonly AudioInfoProviderInterface $audioBrowser,
        private readonly string                     $projectDir,
        private readonly Filesystem                 $filesystem
    )
    {
        $this->statusFilePath = $this->projectDir . '/player-status';
    }

    public function save(AudioPlayingStatus $playerStatus): void
    {
        $this->filesystem->remove($this->statusFilePath);
        $this->filesystem->appendToFile($this->statusFilePath, json_encode($playerStatus));
    }

    public function status(): AudioPlayingStatus
    {
        if (!$this->filesystem->exists($this->statusFilePath)) {
            return AudioPlayingStatus::default();
        }

        $rawStatus = json_decode(file_get_contents($this->statusFilePath), true);

        $playingAudio = match ($audioPlayingStatus = $rawStatus['playingAudio']) {
            null => null,
            default => new CurrentPlayingAudioStatus(
                audio: $this->audioBrowser->findAudio($audioPlayingStatus['playingAudioId']),
                startedAt: $audioPlayingStatus['startedAt']
            )
        };

        $lastPlayedAudio = match ($audioId = $rawStatus['lastPlayedAudioId']) {
            null => null,
            default => $this->audioBrowser->findAudio($audioId)
        };

        return new AudioPlayingStatus($playingAudio, $lastPlayedAudio);
    }
}
