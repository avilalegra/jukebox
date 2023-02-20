<?php

namespace App\Command;

use App\Player\Application\Player\Player;
use App\Playlist\Application\PlayListBrowserInterface;
use App\Shared\Application\AudioBrowserInterface;
use Psr\Log\LoggerInterface;
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
        private Player                   $player,
        private AudioBrowserInterface    $audioBrowser,
        private LoggerInterface          $logger,
        private PlayListBrowserInterface $playListBrowser
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'play-audio|play-queue')
            ->addArgument('id', InputArgument::OPTIONAL, 'audio id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');

        try {
            match ($input->getArgument('action')) {
                'play-audio' => $this->playAudio($id),
                'play-queue' => $this->playQueue()
            };
        } catch (\Throwable $t) {
            $this->logger->error($t->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function playAudio(string $audioId): void
    {
        $audio = $this->audioBrowser->findAudio($audioId);
        $this->player->playAudio($audio);
    }

    private function playQueue(): void
    {
        $playingList = $this->playListBrowser->playingPlaylist();
        $this->player->playAll(...$playingList->audios);
    }
}
