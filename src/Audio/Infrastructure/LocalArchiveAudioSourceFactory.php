<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\AudiosSourceInterface;
use App\Shared\Infrastructure\ZipExtractor;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mime\MimeTypeGuesserInterface;

/**
 * Good enough for just two sources but will need some refactoring to make it usable for more.
 */
readonly class LocalArchiveAudioSourceFactory
{
    public function __construct(
        private MimeTypeGuesserInterface $mimeTypeGuesser,
        private ZipExtractor             $zipExtractor,
        private Filesystem               $filesystem
    )
    {
    }

    public function makeSource(string $filePath): AudiosSourceInterface
    {
        $mimeType = $this->mimeTypeGuesser->guessMimeType($filePath);

        if ($mimeType === 'audio/mpeg') {
            return new ListAudioSource([$filePath]);
        } else if ($mimeType === 'application/zip') {
            return new ZipAudioSource($filePath, $this->zipExtractor, $this->filesystem);
        }

        throw new \Exception("no suitable audio source for the given filepath: {$filePath}");
    }
}