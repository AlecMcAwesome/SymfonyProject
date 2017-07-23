<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddRecipeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class)
            ->add('ingredients', CollectionType::class, array(
                'entry_type' => TextType::class,
                'allow_add' => true,
                'prototype' => true
            ))
            ->add('instructions', TextareaType::class)
            ->add('submit', SubmitType::class, array('label' => 'Create Recipe'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data' => 'AppBundle\Entity\User']);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_new_recipe_form_type';
    }
}

/**
 *             ->add('ingredients', CollectionType::class, array(
'entry_type' => TextType::class,
'allow_add' => true,
'prototype' => true
))
 */