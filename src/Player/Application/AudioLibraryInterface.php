<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\Album;
use App\Shared\Application\Audio;

interface AudioLibraryInterface
{
    public function findAudio(string $audioId): Audio;

    public function findAlbum(string $album): Album;
}
