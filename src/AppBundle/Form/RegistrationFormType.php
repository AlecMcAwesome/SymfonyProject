<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use  Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationFormType extends AbstractType{

    Public function buildForm(FormBuilderInterface $builder, array $options){
        $builder ->
            add('Bio', TextareaType::class);
    }

    public function getParent(){
        return BaseRegistrationFormType::class;
    }
}