<?php

namespace App\Form;

use App\Entity\DistributionBoxFusion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class DistributionBoxFusionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('signalLoss', NumberType::class, ['label' => 'Pérdidas'])
                ->add('fibers', null, [
                    'label' => 'Fibras',
                    'by_reference' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => DistributionBoxFusion::class,
        ]);
    }

}
