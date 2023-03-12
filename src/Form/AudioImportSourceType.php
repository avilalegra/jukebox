<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class AudioImportSourceType extends AbstractType
{
    public function getParent()
    {
        return DropzoneType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new File([
                    'mimeTypes' => ['application/zip', 'audio/mpeg'],
                ], mimeTypesMessage: 'Tipo de archivo no soportado')
            ]
        ]);
    }
}
