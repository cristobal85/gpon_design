<?php

namespace App\Form;

use App\Entity\TubePattern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TubePatternType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label' => 'Nombre'])
                ->add('hexaColor', ColorType::class, ['label' => 'Color'])
                ->add('layer', IntegerType::class, ['label' => 'Layer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => TubePattern::class,
        ]);
    }

}
