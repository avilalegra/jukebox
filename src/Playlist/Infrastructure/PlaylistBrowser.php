<?php

namespace App\Playlist\Infrastructure;

use App\Playlist\Application\Playlist;
use App\Playlist\Application\PlayListBrowserInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlaylistBrowser implements PlayListBrowserInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function mainPlaylist(): Playlist
    {
        $repository = $this->em->getRepository(Playlist::class);

        return $repository->findOneBy(['name' => 'main']);
    }
}