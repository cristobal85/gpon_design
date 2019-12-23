<?php

namespace App\Form;

use App\Entity\CpdPdf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CpdPdfType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('file', VichFileType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => true,
                    'download_label' => new \Symfony\Component\PropertyAccess\PropertyPath('filePath'),
                    'label' => 'Archivo',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CpdPdf::class,
        ]);
    }

}
