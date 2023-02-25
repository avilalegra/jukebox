<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Application\Import\FolderAudiosIterationException;

interface AudiosFolderImporterInterface
{
    /**
     * @throws FolderAudiosIterationException
     */
    public function importAudios(string $folder): void;
}