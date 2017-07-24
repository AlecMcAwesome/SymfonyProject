<?php
/**
 * Created by PhpStorm.
 * User: FrederikPetersen
 * Date: 13/07/2017
 * Time: 12.03
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PublicProfileController extends Controller {


    /*
     * profile controlleren henter in profildataden fra databasen og viser den valgte
     * bruger i en profil på en ny side.
     */
    /**
     * @Route("/profile/{profilename}/", name="profilename")
     */
    public function showProfile($profilename){

        $em = $this->getDoctrine()->getManager();

        $profileData = $em->getRepository('AppBundle:User')
                        ->findOneBy(['username' => $profilename])
            ;

        $recipeData = $em->getRepository('AppBundle:Recipe')
                            ->findBy(['user' => $profileData->getId()])
            ;

        if (!$profileData){
            throw $this->createNotFoundException('profile not found :(');
        }




        return $this->render('Profile/ProfilePage.html.twig', [
            'profile' => $profileData,
            'recipes' => $recipeData
        ]);
    }

}