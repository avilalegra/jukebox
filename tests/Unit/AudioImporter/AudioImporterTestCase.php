<?php

namespace App\Tests\Unit\AudioImporter;

use App\Library\Application\AudioImporter;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Domain\AudioEntity;
use App\Shared\Application\AudioFileName;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

class AudioImporterTestCase extends TestCase
{
    protected $guidGenerator;
    protected $audioStorage;
    protected $audioRepository;

    protected $metadataExtractor;

    protected string $sampleAudioFilePath;

    function assertAudioEntityPersisted(string $id, array $metadata)
    {
        $this->audioRepository
            ->shouldHaveReceived('add')
            ->with(Matchers::equalTo(new AudioEntity($id, ...$metadata)));
    }
    function assertAudioFileImported(string $expectedFileName)
    {
        $this->audioStorage
            ->shouldHaveReceived('importAudioFileAs')
            ->with(Matchers::equalTo(new AudioFileName($expectedFileName)), $this->sampleAudioFilePath);
    }
    function makeImporter(): AudioImporter
    {
        return new AudioImporter($this->guidGenerator, $this->audioStorage, $this->metadataExtractor, $this->audioRepository);
    }
}