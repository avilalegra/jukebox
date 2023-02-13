<?php

namespace App\Library\Application\FileSystem;

class LocalFileSystemException extends \Exception
{
    public function __construct(string $message = "", ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function writeException(string $fileName, ?\Throwable $previous): self
    {
        return new self("couldn't write file: {$fileName}", $previous);
    }

    public static function fileNotFoundException(string $fileName): self
    {
        return new self("couldn't find file: " . $fileName);
    }
}