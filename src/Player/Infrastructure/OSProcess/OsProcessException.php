<?php

namespace App\Player\Infrastructure\OSProcess;

use App\Player\PlayerException;

class OsProcessException extends PlayerException
{
    public function __construct(
        public readonly array  $command,
        public readonly string $errorOutput
    )
    {
        parent::__construct("os process exception");
    }
}