<?php

namespace App\Form;

use App\Entity\DistributionBoxPort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistributionBoxPortType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('number', null, ['label' => 'Número'])
                ->add('fiber', null, ['label' => 'Fibra'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => DistributionBoxPort::class,
        ]);
    }

}
