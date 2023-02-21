<?php

namespace App\Album\WebUI;

use App\Album\Application\AlbumBrowserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/albums', name: 'albums.')]
class AlbumController extends AbstractController
{

    public function __construct(
        private AlbumBrowserInterface $albumBrowser
    )
    {
    }

    #[Route('/', name: 'index')]
    public function albums(): Response
    {
        $albums = $this->albumBrowser->albumsIndex();

        return $this->render('library/albums.html.twig', compact('albums'));
    }
}