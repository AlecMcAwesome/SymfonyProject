<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as ProfileContoller;


class PrivateProfileController extends ProfileContoller
{
    public function showCreatedRecipes(){

        $user = $this->getUser();
        

    }
}
