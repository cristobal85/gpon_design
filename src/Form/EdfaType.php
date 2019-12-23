<?php

namespace App\Form;

use App\Entity\Edfa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EdfaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' =>  'Nombre'
            ])
            ->add('rack')
            ->add('pdfs', CollectionType::class, [
                'entry_type' => EdfaPdfType::class,
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
                'entry_type' => EdfaImageType::class,
                'label' =>  'Imágenes',
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Edfa::class,
        ]);
    }
}
