<?php

declare(strict_types=1);

namespace App\Player\Application\Player\Status;

use App\Shared\Domain\AudioReadModel;

readonly class AudioPlayingStatus implements \JsonSerializable
{
    public function __construct(
        public ?CurrentPlayingAudioStatus $currentPlayingAudio,
        public ?AudioReadModel            $lastPlayedAudio
    )
    {
    }

    public static function default(): AudioPlayingStatus
    {
        return new AudioPlayingStatus(null, null);
    }

    public function playingTransition(AudioReadModel $audio, int $startedAt): self
    {
        return new AudioPlayingStatus(new CurrentPlayingAudioStatus($audio, $startedAt), $this->currentPlayingAudio?->audio);
    }

    public function stopTransition(): self
    {
        return new AudioPlayingStatus(null, $this->currentPlayingAudio?->audio);
    }
    public function isPlaying(AudioReadModel $audio): bool
    {
        return $audio->equals($this->currentPlayingAudio?->audio);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'playingAudio' => $this->currentPlayingAudio ? [
                'playingAudioId' => $this->currentPlayingAudio->audio->id,
                'startedAt' => $this->currentPlayingAudio->startedAt,
            ] : null,
            'lastPlayedAudioId' => $this->lastPlayedAudio?->id,
        ];
    }


}
