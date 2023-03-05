<?php

declare(strict_types=1);

namespace App\WebUI;

use App\Player\Application\Interactor\JukeboxPlayerInterface;
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
        private readonly HubInterface             $mercureHub,
        private readonly JukeboxPlayerInterface   $player,
        private readonly PlayerStatusInfoProviderInterface $playerStatusInfoProvider
    )
    {
    }

    public static function getSubscribedEvents() : array
    {
        return [
            AudioPlayingStarted::name() => 'onAudioPlayingStarted',
            AudioPlayingStopped::name() => 'onAudioPlayingStopped',
        ];
    }


    #[Route('/', name: 'index')]
    public function playerIndex(): Response
    {
        $status = $this->playerStatusInfoProvider->status();

        return $this->render('player/player.html.twig',
            [
                'queuedAudios' => $status->queuedAudios,
                'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio?->audio,
                'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio
            ]
        );
    }

    #[Route('/bar', name: 'bar')]
    public function playerBar(): Response
    {
        $status = $this->playerStatusInfoProvider->status();

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
        $this->player->playAudio($id);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/album/{name}', name: 'play.album', methods: ['POST'])]
    public function playAlbum(string $name): Response
    {
        $this->player->playAlbum($name);
        return $this->redirectToRoute('player.index');
    }

    public function onAudioPlayingStarted(AudioPlayingStarted $_)
    {
        $status = $this->playerStatusInfoProvider->status();

        $this->mercureHub->publish(new Update('player-board',
            $this->renderView('player/player_board_stream.html.twig',
                [
                    'queuedAudios' => $status->queuedAudios,
                    'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio?->audio,
                    'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio,
                ]
            )
        ));

        $this->mercureHub->publish(new Update('player-bar',
            $this->renderView('player/player_bar_stream.html.twig',
                [
                    'nowPlaying' => $status->audioPlayingStatus->currentPlayingAudio,
                    'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio,
                ]
            )
        ));
    }

    public function onAudioPlayingStopped(AudioPlayingStopped $_)
    {
        $status = $this->playerStatusInfoProvider->status();

        $this->mercureHub->publish(new Update('player-bar',
            $this->renderView('player/player_bar_stream.html.twig',
                [
                    'nowPlaying' => null,
                    'lastPlayed' => $status->audioPlayingStatus->lastPlayedAudio
                ]
            )
        ));
    }
}
