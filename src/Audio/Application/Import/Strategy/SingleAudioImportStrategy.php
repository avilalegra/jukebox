<?php

namespace App\Audio\Application\Import\Strategy;

use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;

class SingleAudioImportStrategy implements AudioImportStrategyInterface
{
    const ALLOWED_FORMATS = ['mp3'];

    public function __construct(
        private SingleAudioImporter $audioImporter
    )
    {
    }

    public function canImport(string $filePath): bool
    {
        $ext = explode('.', basename($filePath))[1];

        return in_array($ext, self::ALLOWED_FORMATS);
    }

    public function import(string $filePath): AudiosImportResult
    {
        try {
            $this->audioImporter->importAudio($filePath);

            return AudiosImportResult::noErrors();
        } catch (AudioImportException $e) {
            return AudiosImportResult::withErrors(new AudioImportError($filePath, $e->getMessage()));
        }
    }
}