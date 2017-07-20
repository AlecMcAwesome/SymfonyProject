<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEditProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class)
                ->add('email', EmailType::class)
                ->add('bio', TextareaType::class)
                ->add('submit', SubmitType::class, array('label' => 'Edit User'))
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
            $resolver->setDefaults(['data' => 'AppBundle\Entity\User']);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_admin_edit_profile_form_type';
    }
}


