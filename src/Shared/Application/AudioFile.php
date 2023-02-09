<?php

namespace App\Shared\Application;

class AudioFile
{
    public function __construct(
        private Audio $audio
    )
    {
    }

    public function fileName(): string
    {
        return sprintf('%s-%ss.%s',
            preg_replace('/\s+/', '-', strtolower($this->audio->name)),
            $this->audio->secDuration,
            $this->audio->ext
        );
    }

    public function extension(): string
    {
        return $this->audio->ext;
    }
}