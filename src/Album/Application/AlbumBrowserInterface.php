<?php

declare(strict_types=1);

namespace App\Album\Application;


interface AlbumBrowserInterface
{
    /**
     * @return array<AlbumInfo>
     */
    public function albumsIndex(): array;
}
