<?php

namespace App\DataFixtures;

use App\Playlist\Domain\PlaylistEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PlaylistFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $mainPlaylist = new PlaylistEntity('ee6be059-c8d8-42aa-aad1-76c45d7cb30f','main');
        $manager->persist($mainPlaylist);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'test'];
    }
}
