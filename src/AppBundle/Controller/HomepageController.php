<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    /*
     * homepage henter alle opskrifter fra vores database via doctrines entitymanager
     * derefter redner vi siden med data fra recipes variablen
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('AppBundle:Recipe')
            ->findAll();


        // replace this example code with whatever you need
        return $this->render('Cookbook/Homepage.html.twig', [
            'recipes' => $recipes
        ]);
    }
}
