<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\PlayerStatus;
use App\Player\Application\Player\Status\PlayerStatusRepositoryInterface;
use App\Shared\Application\AudioBrowserInterface;

class PlayerStatusRepository implements PlayerStatusRepositoryInterface
{
    private const STATUS_FILE = 'player-status';

    public function __construct(
        private AudioBrowserInterface $audioBrowser
    ) {
    }

    public function saveCurrentStatus(PlayerStatus $playerStatus): void
    {
        file_put_contents(self::STATUS_FILE, json_encode($playerStatus));
    }

    public function getCurrentStatus(): PlayerStatus
    {
        if (!file_exists(self::STATUS_FILE)) {
            return PlayerStatus::default();
        }

        $rawStatus = json_decode(file_get_contents(self::STATUS_FILE), true);

        $playingAudio = match ($audioPlayingStatus = $rawStatus['playingAudio']) {
            null => null,
            default => new AudioPlayingStatus(
                audio: $this->audioBrowser->findAudio($audioPlayingStatus['playingAudioId']),
                startedAt: $audioPlayingStatus['startedAt']
            )
        };

        $lastPlayedAudio = match ($audioId = $rawStatus['lastPlayedAudioId']) {
            null => null,
            default => $this->audioBrowser->findAudio($audioId)
        };

        return new PlayerStatus($playingAudio, $lastPlayedAudio);
    }
}
