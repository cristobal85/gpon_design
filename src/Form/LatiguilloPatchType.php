<?php

namespace App\Form;

use App\Entity\LatiguilloPatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LatiguilloPatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nombre'])
            ->add('edfaPort', null, ['label' => 'Puerto EDFA'])
            ->add('patchPanelSlotConector', null, ['label' => 'Conector Patch panel'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LatiguilloPatch::class,
        ]);
    }
}
