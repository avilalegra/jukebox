<?php

namespace App\Audio\Application\Import;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Application\AudioFile\AudioStorage;
use App\Audio\Application\GuidGeneratorInterface;
use App\Audio\Application\Interactor\AudioStorageInterface;
use App\Audio\Application\Metadata\AudioMetadataExtractorInterface;
use App\Audio\Domain\AudioEntity;

readonly class AudioImporter
{
    public function __construct(
        private GuidGeneratorInterface          $guidGenerator,
        private AudioStorage                    $audioStorage,
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
            duration: $metadata->duration
        );

        if ($this->audioRepository->hasOneWithSameTitleAndDuration($audio)) {
            return;
        }

        $this->audioStorage->importAudioFile($audio->readModel(), $audioFilePath);
        $this->audioRepository->add($audio);
    }
}