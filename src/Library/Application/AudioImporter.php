<?php

namespace App\Library\Application;

use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Application\Storage\AudioStorageInterface;
use App\Library\Domain\AudioEntity;
use App\Shared\Application\AudioFileName;

class AudioImporter
{
    public function __construct(
        private GuidGeneratorInterface          $guidGenerator,
        private AudioStorageInterface           $audioStorage,
        private AudioMetadataExtractorInterface $metadataExtractor,
        private AudioEntityRepositoryInterface  $audioRepository
    )
    {
    }

    public function importAudio(string $audioFilePath): void
    {
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
    }
}