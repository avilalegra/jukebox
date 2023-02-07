<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\Album;
use App\Shared\Application\Audio;

class PlayerStatus implements \JsonSerializable
{
    public function __construct(
        public readonly ?Album $playingAlbum,
        public readonly ?AudioPlayingStatus $playingAudio,
        public readonly ?Audio $lastPlayedAudio
    ) {
    }

    public static function default(): PlayerStatus
    {
        return new PlayerStatus(null, null, null);
    }

    public function goPlaying(Audio $audio, int $startedAt): self
    {
        return new PlayerStatus($audio->album, new AudioPlayingStatus($audio, $startedAt), $this->playingAudio?->audio);
    }

    public function goStopped(): self
    {
        return new PlayerStatus($this->playingAlbum, null, $this->playingAudio?->audio);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'playingAlbumId' => $this->playingAlbum?->id,
            'playingAudio' => $this->playingAudio ? [
                'playingAudioId' => $this->playingAudio->audio->id,
                'startedAt' => $this->playingAudio->startedAt,
            ] : null,
            'lastPlayedAudioId' => $this->lastPlayedAudio?->id,
        ];
    }
}
