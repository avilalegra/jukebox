<?php

namespace App\DataFixtures\Test;

use App\Audio\Domain\AudioEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AudioFixtures extends Fixture implements FixtureGroupInterface
{
    const AUDIOS_DATA = [
        [
            'id' => '7bd23661-8dd1-45e3-ad34-64772bb56e17',
            'title' => 'Just Push Play (Radio Remix)',
            'extension' => 'mp3',
            'duration' => 191,
            'album' => 'The Essential Aerosmith',
            'artist' => 'Aerosmith',
            'lyrics' => '',
            'genre' => 'Rock',
            'track' => 11,
            'year' => '2002-02-07'
        ],
        [
            'id' => '6bd57da6-4d4f-4185-ad9e-33911330ce7a',
            'title' => 'Deuces Are Wild',
            'extension' => 'mp3',
            'duration' => 216,
            'album' => 'The Essential Aerosmith',
            'artist' => 'Aerosmith',
            'lyrics' => '',
            'genre' => 'Rock',
            'track' => 5,
            'year' => '2002-02-07'
        ],
        [
            'id' => '9b4c87de-4b25-4c37-84bf-6c5d0629a1b3',
            'title' => "Nobody's Listening",
            'extension' => 'mp3',
            'duration' => 178,
            'album' => 'Meteora',
            'artist' => 'Linkin Park',
            'lyrics' => '',
            'genre' => 'Alternative',
            'track' => 11,
            'year' => '2003'
        ],
        [
            'id' => '27b2808d-db58-41c1-a998-9a02487206e8',
            'title' => 'Somewhere I Belong',
            'extension' => 'mp3',
            'duration' => 213,
            'album' => 'Meteora',
            'artist' => 'Linkin Park',
            'lyrics' => '',
            'genre' => 'Alternative',
            'track' => 3,
            'year' => '2003'
        ],
        [
            'id' => '9ca48662-8c4b-448e-89a2-fd6dd1b042a9',
            'title' => 'Like You',
            'extension' => 'mp3',
            'duration' => 257,
            'album' => 'The Open Door',
            'artist' => 'Evanescence',
            'lyrics' => "Stay low / Soft, dark, and dreamless",
            'genre' => 'Alternative Rock',
            'track' => 8,
            'year' => '2006'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::AUDIOS_DATA as $data) {
            $audio = new AudioEntity(
                id: $data['id'],
                title: $data['title'],
                artist: $data['artist'],
                album: $data['album'],
                year: $data['year'],
                track: $data['track'],
                genre: $data['genre'],
                lyrics: $data['lyrics'],
                duration: $data['duration'],
                extension: $data['extension']
            );

            $manager->persist($audio);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}

