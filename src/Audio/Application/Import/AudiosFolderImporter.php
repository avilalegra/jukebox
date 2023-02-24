<?php

namespace App\Audio\Application\Import;

use Psr\Log\LoggerInterface;

class AudiosFolderImporter
{
    public function __construct(
        private FolderAudiosIteratorInterface $audiosIterator,
        private AudioImporterInterface        $audioImporter,
        private LoggerInterface               $logger
    )
    {
    }

    /**
     * @throws FolderAudiosIterationException
     */
    public function importAudios(string $folder): void
    {
        foreach ($this->audiosIterator->iterateAudios($folder) as $audioPath) {
            try {
                $this->audioImporter->importAudio($audioPath);
            } catch (AudioImportException $t) {
                $this->logger->error("failed to import audio: " . $audioPath);
            }
        }
    }
}