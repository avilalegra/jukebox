<?php

namespace App\Tests\Integration\Audio\Infrastructure;

use App\Audio\Domain\AudioReadModel;
use App\Audio\Infrastructure\AudioInfoProvider;
use App\Shared\Application\Pagination\PaginationOrder;
use App\Shared\Application\Pagination\PaginationParams;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AudioInfoProviderTest extends KernelTestCase
{
    private AudioInfoProvider $audioInfoProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->audioInfoProvider = self::getContainer()->get(AudioInfoProvider::class);
    }

    /**
     * @dataProvider paginationDataProvider
     * @return void
     */
    public function testPaginateAudios(PaginationParams $params, array $expectedResults, int $expectedTotalResultsCount): void
    {
        $paginationResults = $this->audioInfoProvider->paginateAudios($params);
        $this->assertEquals($params, $paginationResults->params);
        $this->assertEquals($expectedResults, $paginationResults->pageResults);
        $this->assertEquals($expectedTotalResultsCount, $paginationResults->totalResultsCount);
    }

    protected function paginationDataProvider(): array
    {
        return [
            [
                new PaginationParams(1, 2),
                [
                    new AudioReadModel(
                        id: '6bd57da6-4d4f-4185-ad9e-33911330ce7a',
                        title: 'Deuces Are Wild',
                        artist: 'Aerosmith',
                        album: 'The Essential Aerosmith',
                        year: '2002-02-07',
                        track: 5,
                        genre: 'Rock',
                        lyrics: '',
                        duration: 216,
                        extension: 'mp3'
                    ),
                    new AudioReadModel(
                        id: '7bd23661-8dd1-45e3-ad34-64772bb56e17',
                        title: 'Just Push Play (Radio Remix)',
                        artist: 'Aerosmith',
                        album: 'The Essential Aerosmith',
                        year: '2002-02-07',
                        track: 11,
                        genre: 'Rock',
                        lyrics: '',
                        duration: 191,
                        extension: 'mp3'
                    )
                ],
                5
            ],
            [
                new PaginationParams(1, 2, PaginationOrder::desc('artist')),
                [
                    new AudioReadModel(
                        id: '9b4c87de-4b25-4c37-84bf-6c5d0629a1b3',
                        title: "Nobody's Listening",
                        artist: 'Linkin Park',
                        album: 'Meteora',
                        year: '2003',
                        track: 11,
                        genre: 'Alternative',
                        lyrics: '',
                        duration: 178,
                        extension: 'mp3'
                    ),
                    new AudioReadModel(
                        id: '27b2808d-db58-41c1-a998-9a02487206e8',
                        title: 'Somewhere I Belong',
                        artist: 'Linkin Park',
                        album: 'Meteora',
                        year: '2003',
                        track: 3,
                        genre: 'Alternative',
                        lyrics: '',
                        duration: 213,
                        extension: 'mp3'
                    )
                ],
                5
            ],
            [
                new PaginationParams(1, 2, null, ['album' => 'The Open Door']),
                [
                    new AudioReadModel(
                        id: '9ca48662-8c4b-448e-89a2-fd6dd1b042a9',
                        title: 'Like You',
                        artist: 'Evanescence',
                        album: 'The Open Door',
                        year: '2006',
                        track: 8,
                        genre: 'Alternative Rock',
                        lyrics: "Stay low / Soft, dark, and dreamless",
                        duration: 257,
                        extension: 'mp3'
                    )
                ],
                1
            ],
            [
                new PaginationParams(2, 1, PaginationOrder::desc('title'), ['genre' => 'Alternative']),
                [
                    new AudioReadModel(
                        id: '9b4c87de-4b25-4c37-84bf-6c5d0629a1b3',
                        title: "Nobody's Listening",
                        artist: 'Linkin Park',
                        album: 'Meteora',
                        year: '2003',
                        track: 11,
                        genre: 'Alternative',
                        lyrics: '',
                        duration: 178,
                        extension: 'mp3'
                    ),
                ],
                3
            ],
            [
                new PaginationParams(2, 1, PaginationOrder::asc('title'), ['genre' => 'Alternative', 'album' => 'Meteora']),
                [
                    new AudioReadModel(
                        id: '27b2808d-db58-41c1-a998-9a02487206e8',
                        title: 'Somewhere I Belong',
                        artist: 'Linkin Park',
                        album: 'Meteora',
                        year: '2003',
                        track: 3,
                        genre: 'Alternative',
                        lyrics: '',
                        duration: 213,
                        extension: 'mp3'
                    )
                ],
                2
            ]
        ];
    }
}
