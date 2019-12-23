<?php

namespace App\Form;

use App\Entity\OltPort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OltPortType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('number', null, ['label' => 'Número'])
        ->add('oltSlot', EntityType::class, [
            'class' => \App\Entity\OltSlot::class,
            'label' => 'Tarjeta OLT',
            'constraints' => [
                new NotBlank([
                    'message' => 'Debe seleccionar un slot.',
                ])
            ]
        ])
        ->add('latiguilloEdfa', null, ['label' => 'Latiguillo'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => OltPort::class,
        ]);
    }

}
