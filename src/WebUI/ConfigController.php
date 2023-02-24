<?php

namespace App\WebUI;

use App\Audio\Application\Import\AudiosFolderImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/config', name: 'config.')]
class ConfigController extends AbstractController
{
    public function __construct(
        private string $importSourceFolder,
        private AudiosFolderImporter $audiosImporter
    )
    {
    }

    #[Route('/', name: 'index')]
    public function configurationIndex(): Response
    {
        return $this->render('configuration/config_index.html.twig',
            ['importFolder' => $this->importSourceFolder]
        );
    }

    #[Route('/audios/source', name: 'import.audios', methods: ['POST'])]
    public function importAudios(): Response
    {
        $this->audiosImporter->importAudios($this->importSourceFolder);

        return $this->redirectToRoute('albums.index');
    }
}