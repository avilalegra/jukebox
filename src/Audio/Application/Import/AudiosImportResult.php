<?php

namespace App\Audio\Application\Import;

readonly class AudiosImportResult
{
    /**
     * @param array<AudioImportError> $errors
     */
    public function __construct(
        public array $errors
    )
    {
    }

    public function success(): bool
    {
        return count($this->errors) === 0;
    }

    public static function noErrors() : self
    {
       return new self([]) ;
    }

    public static function withErrors(AudioImportError ...$errors): self
    {
        return new self($errors);
    }
}