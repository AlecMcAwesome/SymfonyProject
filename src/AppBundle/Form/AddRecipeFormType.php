<?php

namespace AppBundle\Form;


use AppBundle\Entity\Ingredients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('instructions', TextareaType::class)
            ->add('submit', SubmitType::class, array('label' => 'Create Recipe'));
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

/*
 *             ->add('ingredients', ChoiceType::class , array(
                'choices' => [
                    new Ingredients()
                ],

                'choice_label' => function($ingrediens){
                    / @var Ingredients $ingrediens /
if (!$ingrediens){
    return strtoupper('No ingrediens :(');
}else{
    return strtoupper($ingrediens->getName());
}

}

))
 */