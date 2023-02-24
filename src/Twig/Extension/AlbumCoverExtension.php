<?php

namespace App\Twig\Extension;

use App\Album\Application\CoverStorageInterface;
use App\Audio\Application\Storage\AudioStorageInterface;
use App\Shared\Application\AudioFileName;
use App\Shared\Domain\AudioReadModel;
use App\Twig\Runtime\AlbumCoverExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AlbumCoverExtension extends AbstractExtension
{
    public function __construct(
        private CoverStorageInterface $coverStorage,
        private AudioStorageInterface $audioStorage
    )
    {
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [AlbumCoverExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('albumCover', [$this, 'albumCover']),
            new TwigFunction('audioFile', [$this, 'audioFile']),
        ];
    }

    public function albumCover(string $album): string
    {
        return $this->coverStorage->getCoverFileName($album) ?? '__default__';
    }

    public function audioFile(AudioReadModel $audio): string
    {
        return AudioFileName::fromAudio($audio)->fileName;
    }
}
