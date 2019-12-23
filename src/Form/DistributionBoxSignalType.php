<?php

namespace App\Form;

use App\Entity\DistributionBoxSignal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistributionBoxSignalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tv', null, ['label'  =>  'Lambda 1550'])
            ->add('down', null, ['label'    =>  'Lambda 1490'])
            ->add('up', null, ['label'  =>  'Lambda 1310'])
            ->add('day', null, ['label' =>  'Fecha'])
            ->add('distributionBox')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DistributionBoxSignal::class,
        ]);
    }
}
