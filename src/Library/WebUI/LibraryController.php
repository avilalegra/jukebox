<?php

declare(strict_types=1);

namespace App\Library\WebUI;

use App\Album\Application\AlbumBrowserInterface;
use App\Library\Application\Import\AudiosFolderImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/library', name: 'library.')]
class LibraryController extends AbstractController
{
    public function __construct(
        private AlbumBrowserInterface $audioBrowser,
        private string                $importSourceFolder,
        private AudiosFolderImporter  $audiosImporter
    )
    {
    }

    #[Route('/albums', name: 'albums')]
    public function albums(): Response
    {
        $albums = $this->audioBrowser->albumsIndex();

        return $this->render('library/albums.html.twig', compact('albums'));
    }


    #[Route('/audios/source', name: 'source', methods: ['POST'])]
    public function importAudios(): Response
    {
        try {
            $this->audiosImporter->importAudios($this->importSourceFolder);

        } catch (\Throwable $t) {
            dd($t);
        }

        return $this->redirectToRoute('library.albums');
    }
}
