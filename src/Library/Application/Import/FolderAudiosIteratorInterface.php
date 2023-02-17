<?php

namespace App\Library\Application\Import;

interface FolderAudiosIteratorInterface
{
    /**
     * @throws FolderAudiosIterationException
     */
    public function iterateAudios(string $folder): iterable;
}