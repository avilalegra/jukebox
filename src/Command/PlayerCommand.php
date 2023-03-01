<?php

namespace App\Command;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\Player;
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
        private Player                            $player,
        private AudioInfoProviderInterface        $audioBrowser,
        private LoggerInterface                   $logger,
        private PlayerStatusInfoProviderInterface $statusInfoProvider
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'play-audio|play-main-playlist')
            ->addArgument('id', InputArgument::OPTIONAL, 'audio id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');

        try {
            match ($input->getArgument('action')) {
                'play-audio' => $this->playAudio($id),
                'play-main-playlist' => $this->playMainPlaylist()
            };
        } catch (\Throwable $t) {
            $this->logger->error($t->getTraceAsString());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function playAudio(string $audioId): void
    {
        $audio = $this->audioBrowser->findAudio($audioId);
        $this->player->playAudio($audio);
    }

    private function playMainPlaylist(): void
    {
        $queue = $this->statusInfoProvider->status()->queue;
        $this->player->playAll(...$queue->audios);
    }
}
