<?php

declare(strict_types=1);

namespace App\Library\WebUI;

use App\Library\Application\AudioLibraryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/library', name: 'library.')]
class LibraryController extends AbstractController
{
    public function __construct(
        private AudioLibraryInterface $audioBrowser
    ) {
    }

    #[Route('/albums', name: 'albums')]
    public function albums(): Response
    {
        $albumNames = $this->audioBrowser->albumNamesIndex();

        return $this->render('library/albums.html.twig', compact('albumNames'));
    }
}
