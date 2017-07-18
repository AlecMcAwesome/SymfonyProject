<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseProfileCrontroller;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrivateProfileController extends BaseProfileCrontroller{

    /**
     * @Route("/profile/private", name="privateProfile")
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

    public function deleteRecipe($name){

        $em = $this->getDoctrine()->getManager();

        $recipeData = $em->getRepository('AppBundle:Recipe')
            ->findOneBy(['title' => $name]);

        $em->remove($recipeData);
        $em->flush();

        return $this->redirectToRoute('privateProfile');

    }


}
