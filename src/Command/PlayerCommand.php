<?php

namespace App\Command;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\Player;
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
        private readonly Player                            $player,
        private readonly AudioInfoProviderInterface        $audioBrowser,
        private readonly PlayerStatusInfoProviderInterface $statusInfoProvider
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
            dd($t);
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
        $queuedAudios = $this->statusInfoProvider->status()->queuedAudios;
        $this->player->playAll(...$queuedAudios);
    }
}
