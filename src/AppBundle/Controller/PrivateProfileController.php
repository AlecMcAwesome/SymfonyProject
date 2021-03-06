<?php

namespace AppBundle\Controller;

use AppBundle\Form\EditRecipeFormType;
use FOS\UserBundle\Controller\ProfileController as BaseProfileCrontroller;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrivateProfileController extends BaseProfileCrontroller{

    /*
     * private profile controller har overrided fosuserbundles profil controller så
     * der kunne laves ekstra features såsom table af ingredienserne.
     */
    /**
     * @Route("/profile/private", name="privateProfile")
     */

    /*
     * overidded funktion der viser user profilen fra fosuserbundle forskellen på denne og fos
     * er at vi har tilføjet et doctrine kald til vores database for at finde opskrifter der stemmer overens med
     * profilen
     */
    public function showAction(){

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        };

        $em = $this->getDoctrine()->getManager();
        $recipeData = $em->getRepository('AppBundle:Recipe')
                        ->findBy(['user' => $user->getId()])
            ;

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'recipes' => $recipeData,
        ));
    }

    /**
     * @Route("/profile/recipes/delete/{name}", name="deleteRecipe")
     *
     */


    /*
     * delete recipe sletter den valgte recipe fra vores table i twig.
     * den det valgte entity kommer fra twigs 'delete' knap i table
     */
    public function deleteRecipe($name){

        $em = $this->getDoctrine()->getManager();

        $recipeData = $em->getRepository('AppBundle:Recipe')
            ->findOneBy(['title' => $name]);

        $em->remove($recipeData);
        $em->flush();

        return $this->redirectToRoute('privateProfile');

    }

    /**
     * @Route("/profile/recipe/edit/{recipeid}/{username}", name="editrecipe")
     */

    public function editRecipe(Request $request, $recipeid, $username){


        $em = $this->getDoctrine()->getManager();

        $recipeData = $em->getRepository('AppBundle:Recipe')
                            ->findOneBy(['id' => $recipeid])
        ;

        if ($recipeData->getUser() == $username){
            $form = $this->createForm(EditRecipeFormType::class, $recipeData);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){

                $recipeData->updatedTimestamps();
                $em->persist($recipeData);
                $em->flush();

                return $this->redirectToRoute('privateProfile');

            }

            return $this->render('Profile/PrivateRecipeProfile.html.twig', array(
                'editrecipeform' => $form->createView(),
                'recipe' => $recipeData
            ));

        }else{
            return $this->createAccessDeniedException('you do not have permission to edit this recipe :(');
        }

    }
}
