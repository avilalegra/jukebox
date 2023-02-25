<?php

declare(strict_types=1);

namespace App\Player\Application\Player\Status;

use App\Shared\Domain\AudioReadModel;

readonly class AudioPlayingStatus implements \JsonSerializable
{
    public function __construct(
        public ?CurrentPlayingAudioStatus $playingAudio,
        public ?AudioReadModel            $lastPlayedAudio
    )
    {
    }

    public static function default(): AudioPlayingStatus
    {
        return new AudioPlayingStatus( null, null);
    }

    public function playingTransition(AudioReadModel $audio, int $startedAt): self
    {
        return new AudioPlayingStatus(new CurrentPlayingAudioStatus($audio, $startedAt), $this->playingAudio?->audio);
    }

    public function stopTransition(): self
    {
        return new AudioPlayingStatus(null, $this->playingAudio?->audio);
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
