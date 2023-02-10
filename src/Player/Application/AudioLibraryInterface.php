<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\Album;
use App\Shared\Application\AudioReadModel;

interface AudioLibraryInterface
{
    public function findAudio(string $audioId): AudioReadModel;

    public function findAlbum(string $album): Album;
}
