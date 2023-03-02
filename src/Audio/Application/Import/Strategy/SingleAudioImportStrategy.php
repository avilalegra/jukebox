<?php

namespace App\Audio\Application\Import\Strategy;

use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\FileInfoExtractorInterface;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;

class SingleAudioImportStrategy implements AudioImportStrategyInterface
{
    const ALLOWED_MIME_TYPES = ['audio/mpeg'];

    public function __construct(
        private SingleAudioImporter $audioImporter,
        private FileInfoExtractorInterface $fileInfoExtractor
    )
    {
    }

    public function canImport(string $filePath): bool
    {
        $mimeType = $this->fileInfoExtractor->mimeType($filePath);

        return in_array($mimeType, self::ALLOWED_MIME_TYPES);
    }

    /**
     * @inheritDoc
     */
    public function import(string $filePath): AudiosImportResult
    {
        try {
            $this->audioImporter->importAudio($filePath);

            return AudiosImportResult::noErrors();
        } catch (AudioImportException $e) {
            return AudiosImportResult::withErrors(new AudioImportError($filePath, $e->getTraceAsString()));
        }
    }
}