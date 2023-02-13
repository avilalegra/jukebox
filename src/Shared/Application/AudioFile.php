<?php

namespace App\Shared\Application;

class AudioFile
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