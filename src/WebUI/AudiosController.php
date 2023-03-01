<?php

namespace App\WebUI;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Interactor\PlayerQueueInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Shared\Application\Pagination\PaginationOrder;
use App\Shared\Application\Pagination\PaginationParams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/audios', name: 'audios.')]
class AudiosController extends AbstractController
{
    const DEFAULT_PAGE_NUMBER = 1;
    const DEFAULT_PAGE_LIMIT = 12;

    public function __construct(
        private AudioInfoProviderInterface        $audioInfoProvider,
        private PlayerStatusInfoProviderInterface $statusInfoProvider,
        private PlayerQueueInterface              $playerQueue,
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {

        $status = $this->statusInfoProvider->status();
        $paginationResults = $this->audioInfoProvider->paginateAudios($this->parsePaginationParams($request));
        $nowPlaying = $status->audioPlayStatus->currentPlayingAudio?->audio;

        return $this->render(
            'audio/audio_browser.html.twig',
            [
                'pagination' => $paginationResults,
                'playerStatus' => $status,
                'nowPlaying' => $nowPlaying
            ]
        );
    }

    #[Route('/{id}/queue', name: 'addToPlayingQueue', methods: ['post'])]
    public function addToPlayingQueue(string $id, Request $request): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->playerQueue->add($audio);

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
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->playerQueue->remove($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => false
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }

    private function parsePaginationParams(Request $request): PaginationParams
    {
        $pageNum = $request->get('page', self::DEFAULT_PAGE_NUMBER);
        $limit = $request->get('limit', self::DEFAULT_PAGE_LIMIT);
        $order = null;

        if ($request->get('orderBy') !== null) {
            try {
                [$field, $dir] = explode(',', $request->get('orderBy'));

                $order = match ($dir) {
                    'desc' => PaginationOrder::desc($field),
                    default => PaginationOrder::asc($field)
                };
            } catch (\Throwable $_) {
            }
        }

        return new PaginationParams($pageNum, $limit, $order);
    }
}