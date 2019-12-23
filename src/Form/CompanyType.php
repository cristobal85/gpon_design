<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CompanyType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, ['label'    =>  'Nombre'])
                ->add('city', null, ['label'    =>  'Ciudad'])
                ->add('logoFile', VichImageType::class, [
                    'required'      =>  false,
                    'allow_delete'  =>  false,
                    'download_uri'  =>  false,
                    'label'         =>  'Logo',
                    'imagine_pattern' => 'height_1080',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

}
