<?php

namespace App\Form;

use App\Entity\TorpedoFusion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Fiber;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TorpedoFusionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('signalLoss', NumberType::class, ['label' => 'Pérdidas'])
                ->add('fibers', null, [
                    'label' => 'Fibras',
                    'by_reference' => true,
                ])
//                ->add('fibers', EntityType::class, [
//                    'class' => Fiber::class,
//                    'query_builder' => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('f')
//                                ->where('f.torpedoFusion is null')
//                                ->orderBy('f.id', 'ASC');
//                    },
//                    'choice_label' => 'tube',
//                    'multiple' => true
//                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => TorpedoFusion::class,
        ]);
    }

}
