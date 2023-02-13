<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Domain\AudioReadModel;

interface AudioLibraryInterface
{
    public function findAudio(string $audioId): AudioReadModel;

}
