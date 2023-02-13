<?php

use App\Library\Application\AudioEntity;
use App\Library\Infrastructure\AudioEntityRepository;
use App\Tests\DbTools;
use App\Tests\IntegrationTestBase;
use Doctrine\ORM\EntityManagerInterface;

uses(IntegrationTestBase::class);
uses(DbTools::class);

test('add audio', function () {
    $audioRepository = new AudioEntityRepository($this->getContainer()->get(EntityManagerInterface::class));

    $audioRepository->add(new AudioEntity(
        '3b798c60-6703-44e4-a617-d8c97fde5043',
        'Like you',
        'Evanescence',
        'The Open Door',
        2009,
        8,
        'Alternative Rock',
        'some lyrics',
        '257',
        'mp3'
    ));

    $savedData = $this->connection()
        ->fetchAssociative('select * from audio where id = :id', ['id' => '3b798c60-6703-44e4-a617-d8c97fde5043']);

    expect($savedData)->toEqualCanonicalizing([
        "id" => '3b798c60-6703-44e4-a617-d8c97fde5043',
        "title" => "Like you",
        "extension" => "mp3",
        "duration" => 257,
        "album" => "The Open Door",
        "artist" => 'Evanescence',
        "lyrics" => 'some lyrics',
        "genre" => 'Alternative Rock',
        "track" => 8,
        "year" => 2009
    ]);
});
