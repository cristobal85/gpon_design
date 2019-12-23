<?php

namespace App\Form;

use App\Entity\DistributionBox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class DistributionBoxType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label' => 'Nombre'])
                ->add('nodo')
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Icono',
                ])
                ->add('address', null, ['label' => 'Dirección'])
                ->add('subscriberBoxes', null, ['label' => 'Cajas Abonado'])
                ->add('latitude', NumberType::class, ['label' => 'Latitud', 'scale' => 16, 'required' => false])
                ->add('longitude', NumberType::class, ['label' => 'Longitud', 'scale' => 16, 'required' => false])
                ->add('layerGroup', null, ['label' => 'Capa'])
                ->add('pdfs', CollectionType::class, [
                    'entry_type' => DistributionBoxPdfType::class,
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
                    'label' => 'Archivos'
                ])
                ->add('images', CollectionType::class, [
                    'entry_type' => DistributionBoxImageType::class,
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
                    'label' => 'Imágenes'
                ])
//                ->add('ports', CollectionType::class, [
//                    'entry_type' => DistributionBoxPortType::class,
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
//                    'label' => 'Puertos'
//                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => DistributionBox::class,
        ]);
    }

}
