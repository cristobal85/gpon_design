<?php

namespace App\Form;

use App\Entity\SubscriberBoxCustomer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SubscriberBoxCustomerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('code', null, ['label' => 'Código'])
                ->add('name', null, ['label' => 'Nombre'])
                ->add('active', CheckboxType::class, ['label' => 'Activo', 'label_attr' => ['class' => 'switch-custom']])
                ->add('subscriberBoxOut', IntegerType::class, ['label' => 'Nº de salida', 'data' => 0])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => SubscriberBoxCustomer::class,
        ]);
    }

}
