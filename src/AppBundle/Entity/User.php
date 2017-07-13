<?php 
// getter & setters bin/console doctrine:generate:entities AppBundle/Entity/Product
// create entity class  php bin/console doctrine:generate:entity


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/*
    User entity! alle rækkerne fra databasen er allerede indsat fra FOSUserbudles eget schema
    du skal kun sætte ID ind og bruge det som primary key
*/

/**
*@ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
*@ORM\Table(name="`User`")
*/
class User extends BaseUser{

    /**
    *@ORM\Id
    *@ORM\GeneratedValue(strategy="AUTO")
    *@ORM\Column(type="integer")
    */

    protected $id;


    /**
    * @ORM\OneToMany(targetEntity="Recipe", mappedBy="user")
    */
    private $recipe;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    protected $bio;

    public function __construct()
    {
        $this->recipe = new ArrayCollection();
    }


    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @return mixed
     */
    public function getRecipe()
    {
        return $this->recipe;
    }


}
