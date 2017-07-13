<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


    class RecipeController extends Controller
    {

        /**
         * @Route("/recipe", name="recipes")
         */

        public function listAction()
        {

            $em = $this->getDoctrine()->getManager();
            $recipees = $em->getRepository('AppBundle:Recipe')
                ->findAll();


            return $this->render("Cookbook/Recipees.html.twig", [
                'recipees' => $recipees
            ]);
        }

        /**
         * @Route("/recipe/new", name = "newRecipe")
         */

        public function addRecipe(){

            $recipe = new Recipe();
            $user = $this->getUser();

            $recipe->setUser($user);
            $recipe->setTitle('test cow');
            $recipe->setInstructions('damn you shouldnt eat, test cow!!!');


            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();





            //return $this->render('/CookBook/addRecipe.html.twig');

            return new Response('<html><body>recipe created</body></html>');
        }


        /**
         * @Route("/recipe/{recipename}", name = "recipename")
         */

        public function showRecipe($recipename)
        {

            $em = $this->getDoctrine()->getManager();

            $recipeData = $em->getRepository('AppBundle:Recipe')
                            ->findOneBy(['title' => $recipename]);
            ;


            if (!$recipeData){
                throw $this->createNotFoundException('damn son we aint go that recipe brah!');
            }


            return $this->render('Cookbook/Recipeprofile.html.twig', [
                'recipe' => $recipeData
            ]);
        }

    }