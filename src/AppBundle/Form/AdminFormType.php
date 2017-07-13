<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('username')
                ->add('email')
                ->add('password')
                ->add('confirmpassword')
                ->add('bio')
                ->add('role')
                ;
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
