<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Form;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType {

    private $auth;

    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'label' => 'Imagen de perfil',
                ])
                ->add('username', TextType::class, array(
                    'label' => 'Nombre de usuario'
                ))
                ->add('email');

        if ($this->auth->isGranted('ROLE_ADMIN')) {
            $this->addRolesField($builder);
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if (!$user || null === $user->getId()) {
                $this->addRequiredPass($form);
            } else {
                $this->addNotRequiredPass($form);
            }
        });
    }

    private function addRolesField(FormBuilderInterface $builder) {
        $builder->add('roles', ChoiceType::class, array(
            'label' => 'Rol',
            'mapped' => true,
            'expanded' => true,
            'multiple' => true,
            'choices' => array(
                'Usuario' => 'ROLE_USER',
                'Administrador' => 'ROLE_ADMIN',
            )
        ));
    }

    private function addRequiredPass(Form $form) {
        $form->add('plainPassword', PasswordType::class, [
            'label' => 'Contraseña',
            'mapped' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Debe introducir una contraseña.',
                        ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                    'max' => 4096,
                        ]),
            ],
        ]);
    }

    private function addNotRequiredPass(Form $form) {
        $form->add('plainPassword', PasswordType::class, [
            'label' => 'Contraseña',
            'mapped' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
