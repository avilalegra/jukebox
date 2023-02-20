<?php

namespace App\Album\WebUI;

use App\Album\Application\AlbumBrowserInterface;
use App\Album\Application\AlbumPlayer;
use App\Playlist\Application\Playing\AsyncPlayerInterface;
use App\Playlist\Application\Playing\PlayingPlaylistEditor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/albums', name: 'albums.')]
class AlbumController extends AbstractController
{

    public function __construct(
        private AlbumBrowserInterface $albumBrowser,
        private AlbumPlayer           $albumPlayer
    )
    {
    }

    #[Route('/', name: 'index')]
    public function albums(): Response
    {
        $albums = $this->albumBrowser->albumsIndex();

        return $this->render('library/albums.html.twig', compact('albums'));
    }

    #[Route('/{name}', name: 'play', methods: ['POST'])]
    public function playAlbum(string $name): Response
    {
        $this->albumPlayer->playAlbum($name);
        return $this->redirectToRoute('playlists.main');
    }
}