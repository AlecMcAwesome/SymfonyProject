<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\AdminForm;
use AppBundle\Form\AdminFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{

    /**
    *   @Route("/admin/profile", name="admin_profile")
    */

    // function der render din template
    public function showAdminP(){

        return $this->render('admin/aProfile.html.twig');
    }

    /**
     * @Route("/admin/users", name="admin_allusers")
     */

    public function getAllUsers(){

        // em henter doctrines manager
        $em = $this->getDoctrine()->getManager();

        // users sætter vi til at hente repository af vores DB og finder alle med findAll()
        $users = $em->getRepository('AppBundle:User')
            ->findAll()
        ;

        // return vores side med users som er 'users'
        return $this->render('admin/aEditprofiles.html.twig', [
           'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin_newuser")
     */

    public function addNewUser(Request $request){

        $usermanager = $this->get('fos_user.user_manager');
        $newUser = $usermanager->createUser();

        // oprette en form med dan for vi har lavet i AdminFormType
        $form = $this->createForm(AdminFormType::class, $newUser);

        // håndtere requested fra submit knappen
        $form->handleRequest($request);
        // hvis formen er submitted (submit knap) og er valid(der ikke står forkerte ting i) dumper i pt dataen
        if ($form->isSubmitted() && $form->isValid()){
            dump($form->getData());
            die;
        }


        return $this->render('admin/aAddUser.html.twig', [
            'admin_newUser' => $form->createView()
        ]);
    }
}