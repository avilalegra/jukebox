<?php

namespace App\Audio\Application\Import;

interface ZipIteratorInterface
{
    /**
     * @throws \Exception
     */
    public function iterateZipFiles(string $zipFilePath) : iterable;
}