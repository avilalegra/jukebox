<?php

use App\Library\Domain\AudioEntity;
use App\Library\Infrastructure\AudioEntityRepository;
use App\Tests\Integration\AudioEntityRepository\AudioEntityRepositoryTestCase;
use Doctrine\ORM\EntityManagerInterface;

uses(AudioEntityRepositoryTestCase::class);


beforeEach(function () {
    $this->audioRepository = new AudioEntityRepository($this->getContainer()->get(EntityManagerInterface::class));
});

test('add audio', function () {
    $expectedAudioData = array_merge(SAMPLE_AUDIO_METADATA, ['id' => SAMPLE_GUID]);

    $this->audioRepository->add(new AudioEntity(...$expectedAudioData));

    $this->expectAudioSaved(SAMPLE_GUID, $expectedAudioData);
});
