<?php

namespace App\Library\Application\Import;

use App\Library\Application\FolderAudiosIteratorInterface;

class AudiosFolderImporter
{
    public function __construct(
        private FolderAudiosIteratorInterface $audiosIterator,
        private AudioImporter                 $audioImporter
    )
    {
    }

    public function importAudios(string $folder): void
    {
        foreach ($this->audiosIterator->iterateAudios($folder) as $audioPath) {
            $this->audioImporter->importAudio($audioPath);
        }
    }
}