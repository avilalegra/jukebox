<?php

namespace App\WebUI\Audio;

use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Form\AudioImportSourceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/library/audios', name: 'audios.')]
class AudiosLibraryImportController extends AbstractController
{
    public function __construct(
        private readonly AudioLibraryManagerInterface $audioLibraryManager
    )
    {
    }

    #[Route('/import', name: 'import', methods: ['get', 'post'])]
    public function uploadAudios(Request $request): Response
    {
        $form = ($this->createFormBuilder())
            ->add('file', AudioImportSourceType::class)
            ->getForm();

        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $file = $file->move('/tmp', $file->getClientOriginalName());

            $importResult = $this->audioLibraryManager->importAudios($file->getRealPath());

            if ($importResult->ok()) {
                return $this->redirectToRoute('audios.index');
            }

            $errors = $importResult->errors;
        }

        return $this->render('audio/import_audios.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}