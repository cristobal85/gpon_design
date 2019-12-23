<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use BM\TrixBundle\Form\Type\TrixType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class NoteType extends AbstractType {

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $user = $this->security->getUser();
        if ($user->isAdmin()) {
            $builder->add('closed', null, ['label' => '¿Cerrada?']);
        }
        
        $builder
                ->add('title', null, ['label' => 'Título'])
                ->add('description', TrixType::class, ['label' => 'Descripción'])
                ->add('observations', TrixType::class, ['label' => 'Observaciones', 'required' => false])
                ->add('latitude', NumberType::class, ['label' => 'Latitud', 'scale' => 16, 'required' => false])
                ->add('longitude', NumberType::class, ['label' => 'Longitud', 'scale' => 16, 'required' => false])
                ->add('file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Imagen',
                ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }

}
