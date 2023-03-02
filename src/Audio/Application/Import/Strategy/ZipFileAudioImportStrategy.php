<?php

namespace App\Audio\Application\Import\Strategy;

use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\FileInfoExtractorInterface;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Audio\Application\Import\ZipIteratorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


#[AutoconfigureTag('audio.import_strategy')]
class ZipFileAudioImportStrategy implements AudioImportStrategyInterface
{
    public function __construct(
        private ZipIteratorInterface       $zipIterator,
        private FileInfoExtractorInterface $fileInfoExtractor,
        private SingleAudioImporter        $audioImporter,

    )
    {
    }

    public function canImport(string $filePath): bool
    {
        return $this->fileInfoExtractor->mimeType($filePath) === 'application/zip';
    }

    public function import(string $filePath): AudiosImportResult
    {
        $errors = [];
        foreach ($this->zipIterator->iterateZipFiles($filePath) as $audioFilePath) {
            try {
                $this->audioImporter->importAudio($audioFilePath);
            } catch (AudioImportException $e) {
                $errors[] = new AudioImportError($audioFilePath, $e->getTraceAsString());
            }
        }

        return AudiosImportResult::withErrors(...$errors);
    }
}