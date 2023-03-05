<?php

namespace App\Audio\Application\Import\Strategy;


use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Shared\Application\File\FileInfoExtractorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


#[AutoconfigureTag('audio.import_strategy')]
class SingleAudioImportStrategy implements AudioImportStrategyInterface
{
    const ALLOWED_MIME_TYPES = ['audio/mpeg'];

    public function __construct(
        private readonly SingleAudioImporter $audioImporter,
        private readonly FileInfoExtractorInterface $fileInfoExtractor
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