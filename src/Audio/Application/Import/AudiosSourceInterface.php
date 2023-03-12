<?php

namespace App\Audio\Application\Import;

interface AudiosSourceInterface
{
    public function audioFilePaths() : \Generator;
}