<?php

namespace App\Library\Application\Import;

class FolderAudiosIterationException extends \Exception
{
    private function __construct(
        public readonly string $folder,
        ?\Throwable            $previous = null
    )
    {
        parent::__construct("couldn't iterate audios", 0, $previous);
    }

    public static function audiosIterationException(string $folder, ?\Throwable $t = null): self
    {
        return new self($folder, $t);
    }
}