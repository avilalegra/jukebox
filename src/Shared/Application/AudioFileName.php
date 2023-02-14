<?php

namespace App\Shared\Application;

use App\Shared\Domain\AudioReadModel;

readonly class AudioFileName
{
    public static function fromAudio(AudioReadModel $audio) : self
    {
        return new self(sprintf('%s-%ss.%s',
            preg_replace('/\s+/', '-', strtolower($audio->title)),
            $audio->duration,
            $audio->extension
        ));
    }

    public function __construct(
        public string $fileName
    )
    {
    }
}