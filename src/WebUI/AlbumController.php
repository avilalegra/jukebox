<?php

namespace App\WebUI;

use App\Album\Application\Interactor\AlbumInfoProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/albums', name: 'albums.')]
class AlbumController extends AbstractController
{

    public function __construct(
        private AlbumInfoProviderInterface $albumBrowser
    )
    {
    }

    #[Route('/', name: 'index')]
    public function albums(): Response
    {
        $albums = $this->albumBrowser->albums();

        return $this->render('album/albums.html.twig', compact('albums'));
    }
}