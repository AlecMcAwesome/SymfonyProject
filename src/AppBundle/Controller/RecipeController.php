<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\Recipe;
use AppBundle\Form\AddRecipeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


    class RecipeController extends Controller
    {


        /**
         * @Route("/recipe/new", name = "newRecipe")
         */

        public function addRecipe(Request $request){


            $ingredients = new Ingredients();
            $recipe = new Recipe();
            $user = $this->getUser();
            $recipe->setUser($user);


            $formRecipe = $this->createForm(AddRecipeFormType::class, $recipe);


            $formRecipe->handleRequest($request);

            if ($formRecipe->isSubmitted() && $formRecipe->isValid()){

                $em = $this->getDoctrine()->getManager();

                $recipe->addIngredients($ingredients);
                $em->persist($recipe);
                $em->flush();

                dump($recipe);
                die;

               //  return $this->redirectToRoute('fos_user_profile_show');
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
                'recipe' => $recipeData
            ]);
        }

    }