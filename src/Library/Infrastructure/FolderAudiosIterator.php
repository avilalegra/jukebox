<?php

namespace App\Library\Infrastructure;

use App\Library\Application\FolderAudiosIteratorInterface;

class FolderAudiosIterator implements FolderAudiosIteratorInterface
{

    public function iterateAudios(string $folder): iterable
    {
        $iterator = new \DirectoryIterator($folder);

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            if($fileInfo->getExtension() === 'mp3') {
               yield $fileInfo->getRealPath();
            }
        }
    }
}