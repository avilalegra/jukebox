<?php

namespace App\Player\Infrastructure\OSProccess;

class OsProcessException extends \Exception
{
    private function __construct(
        public readonly array  $command,
        public readonly string $errorOutput
    )
    {
        parent::__construct("os process exception");
    }

    public static function runException(array $command, string $errorOutput): self
    {
        return new self($command, $errorOutput);
    }
}