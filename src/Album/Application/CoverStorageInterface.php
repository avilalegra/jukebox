<?php

namespace App\Album\Application;

interface CoverStorageInterface
{
    public function getCoverFileName(string $albumName) : ?string;
}