<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\AddRecipeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
    {


        /**
         * @Route("/recipe/new", name = "newRecipe")
         */
        public function addRecipe(Request $request){

            // opretter nyt recipe objekt
            $recipe = new Recipe();
            // henter user fra vores user enitiy der er logget ind
            $user = $this->getUser();
            // setter user til vore nye recipe objekt
            $recipe->setUser($user);

            // opretter form fra vores formtype klasse AddRecipeFormType i Form directory
            $formRecipe = $this->createForm(AddRecipeFormType::class, $recipe);

            // vores form variabel håndtere request når submit knappen trykkes på
            $formRecipe->handleRequest($request);

            // hvis formen er submitted og den er valid(det hele passer til entitiet)
            if ($formRecipe->isSubmitted() && $formRecipe->isValid()){

                // opretter enitity manager hvor vi henter manageren igennem doctrine
                $em = $this->getDoctrine()->getManager();

                // persist objektet (ikke sender, opsætter)
                $em->persist($recipe);

                // sender objektet her til givende table
                $em->flush();

                // sender os til profilen
                 return $this->redirectToRoute('privateProfile');
            }


            return $this->render('/CookBook/addRecipe.html.twig', [
                'newRecipe' => $formRecipe->createView(),
            ]);

        }


        /**
         * @Route("/recipe/{recipename}", name = "recipename")
         */

        /*
         * show recipe tager en variabel ind som er navnet på vores opskrift. navnet er giver fra vores twig template
         */
        public function showRecipe($recipename)
        {


            // opretter enitity manager
            $em = $this->getDoctrine()->getManager();

            /*
             * recipeData variablen sættes til at være den givende entity det passer med den titel vi har
             * fået fra vores twig. hvis den ikke findes smide vi en notfound exception
             */
            $recipeData = $em->getRepository('AppBundle:Recipe')
                            ->findOneBy(['title' => $recipename]);
            ;
            if (!$recipeData){
                throw $this->createNotFoundException('damn son we aint go that recipe brah!');
            }

            // render template
            return $this->render('Cookbook/Recipeprofile.html.twig', [
                'recipe' => $recipeData,
            ]);

        }

        /**
         * @Route("/recipe/download/", name="downloadrecipe")
         */

        public function downloadPDF(){


            $html = $this->renderView(':Cookbook:recipeprofile.html.twig');
            $pdfGenerator = $this->get('spraed.pdf.generator');

            return new Response($pdfGenerator->generatePDF($html),
                200,
                        array(
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'inline; filename="recipe.pdf'
                        ));
        }
    }