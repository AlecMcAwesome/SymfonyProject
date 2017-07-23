<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\AddRecipeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Spraed\PDFGeneratorBundle\PDFGenerator\PDFGenerator;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
    {


        /**
         * @Route("/recipe/new", name = "newRecipe")
         */
        public function addRecipe(Request $request){


            $recipe = new Recipe();
            $user = $this->getUser();
            $recipe->setUser($user);


            $formRecipe = $this->createForm(AddRecipeFormType::class, $recipe);


            $formRecipe->handleRequest($request);

            if ($formRecipe->isSubmitted() && $formRecipe->isValid()){

                $em = $this->getDoctrine()->getManager();

                $em->persist($recipe);
                $em->flush();


                 return $this->redirectToRoute('privateProfile');
            }


            return $this->render('/CookBook/addRecipe.html.twig', [
                'newRecipe' => $formRecipe->createView(),
            ]);

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
                'recipe' => $recipeData,
            ]);

        }
    }