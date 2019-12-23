<?php

namespace App\Form;

use App\Entity\Tube;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TubeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nombre'])
            ->add('hexaColor', ColorType::class, ['label' => 'Color'])
            ->add('layer', IntegerType::class, ['label' => 'Layer'])
            ->add('wire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tube::class,
        ]);
    }
}
