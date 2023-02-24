<?php

namespace App\WebUI;

use App\Shared\Application\AudioBrowserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audios', name: 'audios.')]
class AudiosController extends AbstractController
{
    public function __construct(
        private AudioBrowserInterface $audioBrowser
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $audios = $this->audioBrowser->paginateAudios();
        return $this->render('audio/audio_index.html.twig', compact('audios'));
    }
}