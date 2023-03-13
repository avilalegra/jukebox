<?php

declare(strict_types=1);

namespace App\WebUI;

use App\Album\Application\Interactor\AlbumInfoProviderInterface;
use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Interactor\PlayerInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\AudioPlayingStarted;
use App\Player\Application\Player\AudioPlayingStopped;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/player', name: 'player.')]
class PlayerController extends AbstractController implements EventSubscriberInterface
{
    public function __construct(
        private readonly HubInterface                      $mercureHub,
        private readonly PlayerInterface                   $player,
        private readonly PlayerStatusInfoProviderInterface $statusInfoProvider,
        private readonly AudioInfoProviderInterface        $audioInfoProvider,
        private readonly AlbumInfoProviderInterface        $albumInfoProvider
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AudioPlayingStarted::name() => 'onPlayerStatusChanged',
            AudioPlayingStopped::name() => 'onPlayerStatusChanged',
        ];
    }


    #[Route('/', name: 'index')]
    public function playerIndex(): Response
    {
        $status = $this->statusInfoProvider->playerStatus();

        return $this->render('player/player.html.twig',
            [
                'queuedAudios' => $status->queuedAudios,
                'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio,
                'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio
            ]
        );
    }

    #[Route('/bar', name: 'bar')]
    public function playerBar(): Response
    {
        $status = $this->statusInfoProvider->playerStatus();

        return $this->render('player/player_bar.html.twig',
            [
                'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio,
                'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio
            ]
        );
    }

    #[Route('/audios/playing', name: 'stop', methods: ['post'])]
    public function stop(Request $request): Response
    {
        $this->player->stop();

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/audios/{id}', name: 'play.audio', methods: ['post'])]
    public function playAudio(string $id, Request $request): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->player->playAudio($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/album/{name}', name: 'play.album', methods: ['POST'])]
    public function playAlbum(string $name): Response
    {
        $album = $this->albumInfoProvider->findAlbum($name);
        $this->player->playAlbum($album);
        return $this->redirectToRoute('player.index');
    }

    #[Route('/queue', name: 'play.queue', methods: ['POST'])]
    public function playQueue(): Response
    {
        $this->player->playQueue();
        return $this->redirectToRoute('player.index');
    }

    public function onPlayerStatusChanged(AudioPlayingStarted|AudioPlayingStopped $_)
    {
        $status = $this->statusInfoProvider->playerStatus();

        $this->mercureHub->publish(new Update('player-status',
            $this->renderView('/player/player_stream.html.twig',
                [
                    'queuedAudios' => $status->queuedAudios,
                    'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio,
                    'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio,
                ]
            )
        ));
    }
}
