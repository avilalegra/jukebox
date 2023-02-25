<?php

namespace App\WebUI;

use App\Player\Application\Player\PlayerManager;
use App\Playlist\Application\PlayListBrowserInterface;
use App\Playlist\Application\PlaylistManagerFactory;
use App\Shared\Application\AudioBrowserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/audios', name: 'audios.')]
class AudiosController extends AbstractController
{
    public function __construct(
        private AudioBrowserInterface    $audioBrowser,
        private PlaylistManagerFactory   $playlistManagerFactory,
        private PlayListBrowserInterface $playListBrowser,
        private PlayerManager $player,
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $audios = $this->audioBrowser->paginateAudios();
        $mainPlaylist = $this->playListBrowser->mainPlaylist();
        $nowPlaying = $this->player->getStatus()->playingAudio?->audio;

        return $this->render(
            'audio/audio_browser.html.twig',
            [
                'audios' => $audios,
                'mainPlaylist' => $mainPlaylist,
                'nowPlaying' => $nowPlaying
            ]
        );
    }

    #[Route('/{id}/queue', name: 'addToPlayingQueue', methods: ['post'])]
    public function addToPlayingQueue(string $id, Request $request): Response
    {
        $mainPlaylistManager = $this->playlistManagerFactory->mainPlaylistEditor();
        $audio = $this->audioBrowser->findAudio($id);
        $mainPlaylistManager->addToPlaylist($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => true
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }

    #[Route('/{id}/queue', name: 'removeFromPlayingQueue', methods: ['delete'])]
    public function removeFromPlayingQueue(string $id, Request $request): Response
    {
        $mainPlaylistManager = $this->playlistManagerFactory->mainPlaylistEditor();
        $audio = $this->audioBrowser->findAudio($id);
        $mainPlaylistManager->removeFromPlaylist($audio);


        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => false
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }
}