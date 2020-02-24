<?php

namespace App\Form;

use App\Entity\PatchPanelImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PatchPanelImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Imagen',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatchPanelImage::class,
        ]);
    }
}
