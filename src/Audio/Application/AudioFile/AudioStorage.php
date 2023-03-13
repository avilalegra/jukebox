<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;


readonly class AudioStorage
{
    public function __construct(
        private string $audiosFolder
    )
    {
    }


    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void
    {
        $targetPath = $this->targetPath($audio);
        $h = fopen($audioFilePath, 'r');
        $success = file_put_contents($targetPath, $h);
        if (!$success) {
            throw new \Exception("import audio exception");
        }
    }

    public function findAudioFile(AudioReadModel $audio): AudioFile
    {
        $targetPath = $this->targetPath($audio);

        if (!file_exists($targetPath)) {
            throw  new AudioFileNotFoundException($audio);
        }

        return new AudioFile($targetPath);
    }

    private function targetPath(AudioReadModel $audio): string
    {
        return $this->audiosFolder . '/' . $audio->id;
    }

    public function removeAudioFile(AudioReadModel $audio): void
    {
        $success = unlink($this->targetPath($audio));
        if (!$success) {
            throw new \Exception("couldn't remove file");
        }
    }
}