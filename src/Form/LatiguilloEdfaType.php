<?php

namespace App\Form;

use App\Entity\LatiguilloEdfa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LatiguilloEdfaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nombre'])
            ->add('oltPort', null, ['label' => 'Puerto OLT'])
            ->add('edfaPort', null, ['label' => 'Puerto EDFA'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LatiguilloEdfa::class,
        ]);
    }
}
