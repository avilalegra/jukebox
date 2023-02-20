<?php

declare(strict_types=1);

namespace App\Album\Application;


use App\Shared\Domain\AudioReadModel;

interface AlbumBrowserInterface
{
    /**
     * @return array<AlbumInfo>
     */
    public function albumsIndex(): array;

    /**
     * @return array<AudioReadModel>
     */
    public function findAlbumAudios(string $albumName) : array;
}
