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

    public function ok(): bool
    {
        return count($this->errors) === 0;
    }

    public function ko() : bool
    {
       return !$this->ok();
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