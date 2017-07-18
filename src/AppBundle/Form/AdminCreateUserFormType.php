<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;


class AdminCreateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => ['USER' => 'ROLE_USER', 'ADMIN' => 'ROLE_ADMIN'],
                    'expanded' => true,
                    'multiple' => true,
                ])
            ;

    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }


    //PROMBLEM HER !!!! :: med FOSUserbundle
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data' => 'AppBundle\Entity\User']);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_admin_form_type';
    }
}