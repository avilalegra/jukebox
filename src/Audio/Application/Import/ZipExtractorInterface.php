<?php

namespace App\Audio\Application\Import;

interface ZipExtractorInterface
{
    public function extractTo(string $path) : void;
}