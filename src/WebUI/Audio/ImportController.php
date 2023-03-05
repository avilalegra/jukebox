<?php

namespace App\WebUI\Audio;

use App\Audio\Application\Interactor\AudioImporterInterface;
use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Form\AudioImportSourceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/audios', name: 'audios.')]
class ImportController extends AbstractController
{
    public function __construct(
        private readonly AudioImporterInterface $audioImporter
    )
    {
    }

    #[Route('/library', name: 'import', methods: ['get', 'post'])]
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

            $importResult = $this->audioImporter->import($file->getRealPath());

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