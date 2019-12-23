<?php

namespace App\Form;

use App\Entity\Nodo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class NodoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('number', IntegerType::class, [
                    'label' => 'Numero'
                ])
                ->add('name', TextType::class, [
                    'label' => 'Nombre'
                ])
                ->add('color', ColorType::class)
                ->add('addresses', null, ['label' => 'Dirección'])
                ->add('pdfs', CollectionType::class, [
                    'entry_type' => NodoPdfType::class,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Nodo::class,
        ]);
    }

}
