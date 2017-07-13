<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('username', TextType::class)
                ->add('email', EmailType::class)
                ->add('password', PasswordType::class)
                ->add('confirmpassword', PasswordType::class, ['mapped' => false])
                ->add('bio', TextareaType::class)
                ->add('role', ChoiceType::class, ['mapped' => User::ROLE_DEFAULT], array(
                    'choices' => array(
                        'admin' => true,
                        'user' => false,
                    ),
                ));
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
