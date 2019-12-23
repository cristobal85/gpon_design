<?php

namespace App\Form;

use App\Entity\SubscriberBoxExt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SubscriberBoxExtType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label' => 'Nombre'])
                ->add('latitude', NumberType::class, ['label' => 'Latitud', 'scale' => 16, 'required' => false])
                ->add('longitude', NumberType::class, ['label' => 'Longitud', 'scale' => 16, 'required' => false])
                ->add('tubeColor', null, ['label'   =>  'Color de tubo'])
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Icono',
                ])
                ->add('subscriberBox', null, ['label' => 'Caja de abonado'])
                ->add('address', null, ['label' => 'Dirección'])
                ->add('pdfs', CollectionType::class, [
                    'entry_type' => SubscriberBoxExtPdfType::class,
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
                    'entry_type' => SubscriberBoxExtImageType::class,
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
                ->add('customers', CollectionType::class, [
                    'entry_type' => SubscriberBoxCustomerType::class,
                    'label' => 'Clientes',
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
            'data_class' => SubscriberBoxExt::class,
        ]);
    }

}
