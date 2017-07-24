<?php

namespace AppBundle\Controller;


use AppBundle\Form\AdminCreateUserFormType;
use AppBundle\Form\AdminEditProfileFormType;
use AppBundle\Form\EditRecipeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{

    /**
    *   @Route("/admin/profile", name="admin_profile")
    */

    // function der render din template
    public function showAdminP(){

        // render admin template
        return $this->render('admin/aProfile.html.twig');
    }

    /**
     * @Route("/admin/recipes", name="admin_recipes")
     */

    public function getRecipes(){
        /* entity manageren finder alle opskrifter i vores database
         * og sender dem til vores twig der looper igennem dem i et table
         */
        $em = $this->getDoctrine()->getManager();
        $recipees = $em->getRepository('AppBundle:Recipe')
            ->findAll();


        return $this->render("admin/aRecipes.html.twig", [
            'recipees' => $recipees
        ]);
    }

    /**
     * @Route("/admin/recipes/edit/{name}", name="admin_editrecipe")
     */

    public function editRecipe(Request $request, $name){

        $em = $this->getDoctrine()->getManager();

        /*
         * recipeData henter en enkelt entity via doctrine der stemmer overens med titlen på opskriften
         */
        $recipeData = $em->getRepository('AppBundle:Recipe')
                    ->findOneBy(['title' => $name])
            ;

        // opretter form fra vores form diretory kaldet EditRecipeFormType
        $form = $this->createForm(EditRecipeFormType::class, $recipeData);

        $form->handleRequest($request);


        /*
         * hvis begge statements er valid så opdatere entitiet med et nyt timestamp
         */
        if ($form->isSubmitted() && $form->isValid()){

            $recipeData->updatedTimestamps();
            $em->persist($recipeData);
            $em->flush();

            // sender os tilbage til opskrift listen
            return $this->redirectToRoute('admin_recipes');

        }

        // viser editrecipe siden med formen og data for den valgte opskrift
        return $this->render('admin/aEditRecipe.html.twig', array(
            'editrecipe' => $form->createView(),
            'recipedata' => $recipeData
        ));


    }

    /**
     * @Route("/admin/recipes/delete/{name}", name="admin_deleteRecipe")
     */

    // fjerne valgte opskrift
    public function deleteRecipe($name){

        // opretter enitity manager
        $em = $this->getDoctrine()->getManager();

        // henter en valgt entity fra recipe som passer til titel
        $recipeData = $em->getRepository('AppBundle:Recipe')
                    ->findOneBy(['title' => $name]);

        // opsætter fjernelse af valgte entity
        $em->remove($recipeData);
        // sender query
        $em->flush();

        // retunere os til opskrifter på admin siden
        return $this->redirectToRoute('admin_recipes');

    }

    /**
     * @Route("/admin/users", name="admin_allusers")
     */

    /*
     * giver os en liste med users/admins
     */
    public function getAllUsers(){

        // em henter doctrines manager
        $em = $this->getDoctrine()->getManager();

        // users sætter vi til at hente repository af vores DB og finder alle med findAll()
        $users = $em->getRepository('AppBundle:User')
            ->findAll()
        ;

        // return vores side med users som er 'users'
        return $this->render('admin/aShowprofiles.html.twig', [
           'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/edit/{userid}", name="admin_edituser")
     */

    public function editUser(Request $request, $userid){

        // opretter entity manager
        $em = $this->getDoctrine()->getManager();

        // finder user med samme id
        $userData = $em->getRepository('AppBundle:User')
                ->findOneBy(['id' => $userid ]);

        // hvis user ikke findes kommer der en exception
        if (!$userData) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        // opretter formen fra AdminEditFormType med userdata
        $form = $this->createForm(AdminEditProfileFormType::class, $userData);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid()){

            $em->persist($userData);
            $em->flush();

            return $this->redirectToRoute('admin_allusers');

        }



        return $this->render('admin/aEditUser.html.twig', array(
            'userform' => $form->createView(),
            'user' => $userData,
        ));
    }

    /**
     * @Route("/admin/user/new", name="admin_newuser")
     */

    // admin tilføjer en my bruger
    public function addNewUser(Request $request){

        // usermanager hentes fra fosuserbundles bundle
        $userManager = $this->get('fos_user.user_manager');

        // $newuser er lig med usermanagers create user funktion i fosuserbundle.
        $newUser = $userManager->createUser();

        // opretter en form med den form vi har lavet i AdminCreateUserFormType
        $form = $this->createForm(AdminCreateUserFormType::class, $newUser);

        // håndtere requested fra submit knappen
        $form->handleRequest($request);
        // hvis formen er submitted (submit knap) og er valid(der ikke står forkerte ting i) dumper i pt dataen
        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();

            //dump($form->getData());
            //die;

            return $this->redirectToRoute('admin_profile');

        }



        return $this->render('admin/aAddUser.html.twig', [
            'admin_newUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_deleteuser")
     */
    // admin kan slette bruger
    public function deleteUser($id){


        $em = $this->getDoctrine()->getManager();

        /*
         * her finder vi  den enkelte user og de opskrifter som brugeren har lavet
         * dette gøres fordi nå brugeren slettes, slettes alle hans/hendes opskrifter også
         */
        $recipeData = $em->getRepository('AppBundle:Recipe')
            ->findOneBy(['user' => $id]);

        $profileData = $em->getRepository('AppBundle:User')
            ->findOneBy(['id' => $id]);

        /*
         * hvis du brugeren ikke har oprettet nogen opskriter sletter vi bare brugeren
         * ellers sletter vi både bruger og opskrifter
         */
        $em->remove($profileData);
        if(!$recipeData){
            $em->flush();
        }else {
            $em->remove($recipeData);
            $em->flush();
        }
        // sender os til bruger listen
        return $this->redirectToRoute('admin_allusers');



    }
}