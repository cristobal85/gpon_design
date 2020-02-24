<?php

namespace App\Form;

use App\Entity\CpdImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CpdImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Imagen',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CpdImage::class,
        ]);
    }

}
