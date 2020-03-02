<?php

namespace App\Form;

use App\Entity\DistributionBox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DistributionBoxUploadImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('images', CollectionType::class, [
                    'entry_type' => DistributionBoxImageType::class,
                    'label' => 'Imágenes',
                    'entry_options' => [
                        'label' => false,
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => false,
                    'by_reference' => false,
                    'attr' => array(
                        'class' => 'collection-type',
                    ),
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => DistributionBox::class,
        ]);
    }

}
