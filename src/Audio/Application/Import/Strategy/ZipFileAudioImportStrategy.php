<?php

namespace App\Audio\Application\Import\Strategy;


use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\FileInfoExtractorInterface;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Audio\Infrastructure\LocalFileSystemInterface;
use App\Shared\Application\Zip\ZipExtractorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


#[AutoconfigureTag('audio.import_strategy')]
class ZipFileAudioImportStrategy implements AudioImportStrategyInterface
{
    public function __construct(
        private LocalFileSystemInterface   $localFileSystem,
        private ZipExtractorInterface      $zipExtractor,
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
        $tempDirPath = $this->localFileSystem->makeTempDir();
        $this->zipExtractor->extract($filePath, $tempDirPath);

        $errors = [];

        foreach ($this->localFileSystem->iterateFilesRecursive($tempDirPath) as $audioFilePath) {
            try {
                $this->audioImporter->importAudio($audioFilePath);
            } catch (AudioImportException $e) {
                $errors[] = new AudioImportError($audioFilePath, $e->getTraceAsString());
            }
        }

        return AudiosImportResult::withErrors(...$errors);
    }
}