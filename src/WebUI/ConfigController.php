<?php

namespace App\WebUI;

use App\Audio\Application\Interactor\AudioImporterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/config', name: 'config.')]
class ConfigController extends AbstractController
{
    public function __construct(
        private AudioImporterInterface $audioImporter
    )
    {
    }

    #[Route('/', name: 'index')]
    public function configurationIndex(): Response
    {
        return $this->render('configuration/config_index.html.twig');
    }

    #[Route('/audios/source', name: 'import.audios', methods: ['POST'])]
    public function importAudios(Request $request): Response
    {
        $this->audioImporter->importFrom($request->get('importSource'));

        return $this->redirectToRoute('albums.index');
    }
}