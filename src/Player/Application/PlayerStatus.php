<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Domain\AudioReadModel;

class PlayerStatus implements \JsonSerializable
{
    public function __construct(
        public readonly ?AudioPlayingStatus $playingAudio,
        public readonly ?AudioReadModel $lastPlayedAudio
    )
    {
    }

    public static function default(): PlayerStatus
    {
        return new PlayerStatus( null, null);
    }

    public function playingTransition(AudioReadModel $audio, int $startedAt): self
    {
        return new PlayerStatus(new AudioPlayingStatus($audio, $startedAt), $this->playingAudio?->audio);
    }

    public function stopTransition(): self
    {
        return new PlayerStatus(null, $this->playingAudio?->audio);
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'playingAudio' => $this->playingAudio ? [
                'playingAudioId' => $this->playingAudio->audio->id,
                'startedAt' => $this->playingAudio->startedAt,
            ] : null,
            'lastPlayedAudioId' => $this->lastPlayedAudio?->id,
        ];
    }
}
