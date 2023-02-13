<?php

namespace App\Player\Infrastructure\OSProccess;

class OsProcessException extends \Exception
{
    public function __construct(
        public readonly string $errorOutput
    )
    {
        parent::__construct("os process exception");
    }
}