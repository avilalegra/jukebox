<?php

namespace App\Audio\Application\Import;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Application\AudioFileName;
use App\Audio\Application\GuidGeneratorInterface;
use App\Audio\Application\Metadata\AudioMetadataExtractorInterface;
use App\Audio\Application\Storage\AudioStorageInterface;
use App\Audio\Domain\AudioEntity;

class SingleAudioImporter
{
    public function __construct(
        private GuidGeneratorInterface          $guidGenerator,
        private AudioStorageInterface           $audioStorage,
        private AudioMetadataExtractorInterface $metadataExtractor,
        private AudioEntityRepositoryInterface  $audioRepository
    )
    {
    }

    /**
     * @throws AudioImportException
     */
    public function importAudio(string $audioFilePath): void
    {
        try {
            $metadata = $this->metadataExtractor->extractMetadata($audioFilePath);

            $defaultName = explode('.', basename($audioFilePath))[0];

            $audio = new AudioEntity(
                id: $this->guidGenerator->generateGuid(),
                title: $metadata->title ?? $defaultName,
                artist: $metadata->artist,
                album: $metadata->album,
                year: $metadata->year,
                track: $metadata->track,
                genre: $metadata->genre,
                lyrics: $metadata->lyrics,
                duration: $metadata->duration,
                extension: $metadata->extension
            );

            $this->audioStorage->importAudioFileAs(AudioFileName::fromAudio($audio->readModel()), $audioFilePath);
            $this->audioRepository->add($audio);

        } catch (\Throwable $t) {
            throw  new AudioImportException($audioFilePath, $t);
        }
    }
}