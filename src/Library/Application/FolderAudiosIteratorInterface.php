<?php

namespace App\Library\Application;

interface FolderAudiosIteratorInterface
{
    public function iterateAudios(string $folder): iterable;
}