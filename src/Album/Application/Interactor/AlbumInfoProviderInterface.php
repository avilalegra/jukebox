<?php

declare(strict_types=1);

namespace App\Album\Application\Interactor;


use App\Album\Application\AlbumInfo;
use App\Album\Domain\Album;
use App\Audio\Domain\AudioReadModel;

interface AlbumInfoProviderInterface
{
    /**
     * @return array<AlbumInfo>
     */
    public function albums(): array;

    public function findAlbum(string $albumName) : Album;
}
