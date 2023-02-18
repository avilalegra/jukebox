<?php

namespace App\Album\Application;

interface CoverStorageInterface
{
    public function searchCoverFileName(string $albumName) : ?string;
}