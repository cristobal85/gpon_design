<?php

namespace App\Form;

use App\Entity\Torpedo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TorpedoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label' => 'Nombre'])
                ->add('latitude', NumberType::class, ['label' => 'Latitud', 'scale' => 16, 'required' => false])
                ->add('longitude', NumberType::class, ['label' => 'Longitud', 'scale' => 16, 'required' => false])
                ->add('address', null, ['label' => 'Dirección'])
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Icono',
                ])
                ->add('layerGroup', null, ['label' => 'Capa'])
                ->add('pdfs', CollectionType::class, [
                    'entry_type' => TorpedoPdfType::class,
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
                    'entry_type' => TorpedoImageType::class,
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
//                ->add('torpedoFusions', CollectionType::class, [
//                    'entry_type' => TorpedoFusionType::class,
//                    'label' => 'Fusiones',
//                    'entry_options' => [
//                        'label' => false,
//                    ],
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                    'prototype' => true,
//                    'required' => false,
//                    'by_reference' => false,
//                    'attr' => array(
//                        'class' => 'collection-type',
//                    ),
//                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Torpedo::class,
        ]);
    }

}
