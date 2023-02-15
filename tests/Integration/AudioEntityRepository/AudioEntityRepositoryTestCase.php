<?php

namespace App\Tests\Integration\AudioEntityRepository;

use App\Library\Infrastructure\AudioEntityRepository;
use App\Tests\DbTools;
use App\Tests\Integration\IntegrationTestCase;

class AudioEntityRepositoryTestCase extends IntegrationTestCase
{
    use DbTools;

    protected AudioEntityRepository $audioRepository;

    protected function expectAudioSaved(string $audioId, array $expectedAudioData): void
    {
        $savedData = $this->connection()
            ->fetchAssociative('select * from audio where id = :id', ['id' => $audioId]);

        expect($savedData)->toEqualCanonicalizing($expectedAudioData);
    }
}