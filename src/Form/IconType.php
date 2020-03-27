<?php

namespace App\Form;

use App\Entity\Icon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Torpedo;
use App\Entity\DistributionBox;
use App\Entity\SubscriberBox;
use App\Entity\SubscriberBoxExt;
use App\Entity\Note;

class IconType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('element', ChoiceType::class, [
                    'label' => 'Elemento',
                    'choices' => [
                        'Torpedo' => Torpedo::class,
                        'Caja de distribución' => DistributionBox::class,
                        'Caja de abonado' => SubscriberBox::class,
                        'Caja de extensión' => SubscriberBoxExt::class,
                        'Nota' => Note::class
                    ],
                ])
                ->add('height', IntegerType::class, ['label' => 'Tamaño altura (pixels)'])
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Icono',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Icon::class,
        ]);
    }

}
