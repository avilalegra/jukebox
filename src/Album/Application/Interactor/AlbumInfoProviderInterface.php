<?php

declare(strict_types=1);

namespace App\Album\Application\Interactor;


use App\Album\Application\AlbumInfo;
use App\Shared\Domain\AudioReadModel;

interface AlbumInfoProviderInterface
{
    /**
     * @return array<AlbumInfo>
     */
    public function albums(): array;

    /**
     * @return array<AudioReadModel>
     */
    public function findAlbumAudios(string $albumName) : array;
}
