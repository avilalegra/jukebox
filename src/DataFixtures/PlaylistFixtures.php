<?php

namespace App\DataFixtures;

use App\Player\Application\Player\PlayerQueueManager;
use App\Playlist\Domain\PlaylistEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PlaylistFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $mainPlaylist = new PlaylistEntity(PlayerQueueManager::PLAYER_QUEUE_PLAYLIST_ID,'main');
        $manager->persist($mainPlaylist);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'test'];
    }
}
