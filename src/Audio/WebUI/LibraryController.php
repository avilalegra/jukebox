<?php

declare(strict_types=1);

namespace App\Audio\WebUI;

use App\Audio\Application\Import\AudiosFolderImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/library', name: 'library.')]
class LibraryController extends AbstractController
{
    public function __construct(
        private string               $importSourceFolder,
        private AudiosFolderImporter $audiosImporter
    )
    {
    }


    #[Route('/audios/source', name: 'source', methods: ['POST'])]
    public function importAudios(): Response
    {
        $this->audiosImporter->importAudios($this->importSourceFolder);

        return $this->redirectToRoute('albums.index');
    }
}
