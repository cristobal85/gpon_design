<?php

namespace App\Form;

use App\Entity\LayerGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class LayerGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label'    =>  'Nombre'])
            ->add('hexaColor', ColorType::class, ['label' => 'Color'])
            ->add('weight', null, ['label' => 'Tamaño'])
            ->add('position', null, ['label' => 'Posición', 'data' => 1])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LayerGroup::class,
        ]);
    }
}
