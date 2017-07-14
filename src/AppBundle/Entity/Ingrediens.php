<?php
/**
 * Created by PhpStorm.
 * User: FrederikPetersen
 * Date: 14/07/2017
 * Time: 18.06
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


class Ingrediens
{

    /**
     * @ORM\Column(type="string")
     */
    private $name;
}