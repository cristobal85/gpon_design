<?php

namespace App\Form;

use App\Entity\EdfaPort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EdfaPortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, ['label' => 'Número'])
            ->add('edfaSlot', null, ['label' => 'Slot de EDFA'])
            ->add('latiguilloEdfa', null, ['label' => 'Latiguillo'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EdfaPort::class,
        ]);
    }
}
