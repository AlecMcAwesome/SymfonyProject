<?php

namespace AppBundle\Form;


use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('instructions', TextareaType::class)
            ->add('submit', SubmitType::class, array('label' => 'Create Recipe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data' => 'AppBundle\Entity\Recipe']);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_new_recipe_form_type';
    }
}
