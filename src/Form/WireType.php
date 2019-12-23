<?php

namespace App\Form;

use App\Entity\Wire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WireType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label' => 'Nombre'])
                ->add('longitude', null, ['label' => 'Longitud'])
                ->add('hexaColor', ColorType::class, ['label' => 'Color'])
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Imagen sección cable',
                ])
                ->add('weight', null, ['label' => 'Tamaño'])
                ->add('layerGroup', null, ['label' => 'Capa'])
                ->add('wirePattern', null, ['label' => 'Tipo de cable'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Wire::class,
        ]);
    }

}
