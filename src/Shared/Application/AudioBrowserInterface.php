<?php

namespace App\Shared\Application;

use App\Shared\Domain\AudioReadModel;

interface AudioBrowserInterface
{
    public function findAudio(string $audioId): AudioReadModel;
}