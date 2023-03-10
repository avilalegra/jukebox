<?php

namespace App\Command;

use App\Album\Application\Interactor\AlbumInfoProviderInterface;
use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Player\SyncPlayer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:player',
    description: 'Player command',
)]
class PlayerCommand extends Command
{
    public function __construct(
        private readonly SyncPlayer                 $player,
        private readonly AudioInfoProviderInterface $audioInfoProvider,
        private readonly AlbumInfoProviderInterface $albumInfoProvider
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'play-audio|play-album|play-queue')
            ->addArgument('id', InputArgument::OPTIONAL, 'audio id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');

        try {
            match ($input->getArgument('action')) {
                'play-audio' => $this->playAudio($id),
                'play-album' => $this->playAlbum($id),
                'play-queue' => $this->playQueue()
            };
        } catch (\Throwable $t) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function playAudio(string $audioId): void
    {
        $audio = $this->audioInfoProvider->findAudio($audioId);
        $this->player->playAudio($audio);
    }

    private function playAlbum(string $albumName): void
    {
        $album = $this->albumInfoProvider->findAlbum($albumName);
        $this->player->playAlbum($album);
    }

    private function playQueue(): void
    {
        $this->player->playQueue();
    }
}
