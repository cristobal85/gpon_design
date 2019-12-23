<?php

namespace App\Form;

use App\Entity\PatchPanelSlotConector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatchPanelSlotConectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, ['label' => 'Número'])
            ->add('patchPanelSlot', null, ['label' => 'Tarjeta Patch panel'])
            ->add('fiber', null, ['label' => 'Fibra'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatchPanelSlotConector::class,
        ]);
    }
}
