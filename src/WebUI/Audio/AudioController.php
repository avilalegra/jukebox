<?php

namespace App\WebUI\Audio;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audios', name: 'audios.')]
class AudioController extends AbstractController
{

    public function __construct(
        private readonly AudioInfoProviderInterface   $audioInfoProvider,
        private readonly AudioLibraryManagerInterface $audioLibraryManager
    )
    {
    }

    #[Route('/{id}', name: 'show', methods: ['get'])]
    public function show(string $id): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        return $this->render('audio/audio_details.html.twig', compact('audio'));
    }

    #[Route('/{id}', name: 'delete', methods: ['delete'])]
    public function delete(string $id): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->audioLibraryManager->removeAudio($audio);

        return $this->redirectToRoute('audios.index');
    }
}