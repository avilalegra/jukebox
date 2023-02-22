<?php

namespace App\Audio\Application\Import;

interface FolderAudiosIteratorInterface
{
    /**
     * @throws FolderAudiosIterationException
     */
    public function iterateAudios(string $folder): iterable;
}