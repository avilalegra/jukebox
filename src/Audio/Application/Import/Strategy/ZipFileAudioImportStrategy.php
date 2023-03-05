<?php

namespace App\Audio\Application\Import\Strategy;


use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\SingleAudioImporter;
use App\Shared\Application\File\FileInfoExtractorInterface;
use App\Shared\Application\File\LocalFileSystemInterface;
use App\Shared\Application\File\ZipExtractorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


#[AutoconfigureTag('audio.import_strategy')]
readonly class ZipFileAudioImportStrategy implements AudioImportStrategyInterface
{
    public function __construct(
        private LocalFileSystemInterface   $localFileSystem,
        private ZipExtractorInterface      $zipExtractor,
        private FileInfoExtractorInterface $fileInfoExtractor,
        private SingleAudioImporter        $audioImporter,

    )
    {
    }

    /**
     * @inheritDoc
     */
    public function canImport(string $filePath): bool
    {
        return $this->fileInfoExtractor->mimeType($filePath) === 'application/zip';
    }

    /**
     * @inheritDoc
     */
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