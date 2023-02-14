<?php

namespace App\Shared\Application;

use App\Shared\Domain\AudioReadModel;

class AudioFileName
{
    public function __construct(
        private AudioReadModel $audio
    )
    {
    }

    public function fileName(): string
    {
        return sprintf('%s-%ss.%s',
            preg_replace('/\s+/', '-', strtolower($this->audio->title)),
            $this->audio->duration,
            $this->audio->extension
        );
    }
}