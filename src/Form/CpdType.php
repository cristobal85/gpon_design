<?php

namespace App\Form;

use App\Entity\Cpd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CpdType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('location', null, ['label' => 'Dirección'])
                ->add('latitude', NumberType::class, ['label' => 'Latitud', 'scale' => 16])
                ->add('longitude', NumberType::class, ['label' => 'Longitud', 'scale' => 16])
                ->add('company', EntityType::class, [
                    'class' => \App\Entity\Company::class,
                    'label' => 'Empresa',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Debe seleccionar una Empresa.',
                                ])
                    ]
                ])
                ->add('pdfs', CollectionType::class, [
                    'entry_type' => CpdPdfType::class,
                    'label' => 'Archivos',
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
                ->add('images', CollectionType::class, [
                    'entry_type' => CpdImageType::class,
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
            'data_class' => Cpd::class,
        ]);
    }

}
