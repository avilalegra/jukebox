<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Player\Status\CurrentPlayingAudioStatus;
use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;

class AudioPlayingStatusRepository implements AudioPlayingStatusRepositoryInterface
{
    private const STATUS_FILE = 'player-status';

    public function __construct(
        private AudioInfoProviderInterface $audioBrowser
    ) {
    }

    public function save(AudioPlayingStatus $playerStatus): void
    {
        file_put_contents(self::STATUS_FILE, json_encode($playerStatus));
    }

    public function status(): AudioPlayingStatus
    {
        if (!file_exists(self::STATUS_FILE)) {
            return AudioPlayingStatus::default();
        }

        $rawStatus = json_decode(file_get_contents(self::STATUS_FILE), true);

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
