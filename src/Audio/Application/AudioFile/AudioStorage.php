<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;
use Symfony\Component\Filesystem\Filesystem;


readonly class AudioStorage
{
    public function __construct(
        private string     $audiosFolder,
        private Filesystem $filesystem
    )
    {
    }


    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void
    {
        $targetPath = $this->targetPath($audio);
        $this->filesystem->copy($audioFilePath, $targetPath);
    }

    public function findAudioFile(AudioReadModel $audio): AudioFile
    {
        $targetPath = $this->targetPath($audio);

        if (!$this->filesystem->exists($targetPath)) {
            throw  new \Exception('audio not found');
        }

        return new AudioFile($targetPath);
    }

    private function targetPath(AudioReadModel $audio): string
    {
        return $this->audiosFolder . '/' . $audio->id;
    }

    public function removeAudioFile(AudioReadModel $audio): void
    {
        $this->filesystem->remove($this->targetPath($audio));
    }
}