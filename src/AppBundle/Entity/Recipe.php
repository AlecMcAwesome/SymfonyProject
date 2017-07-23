<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping as ORM;

/**
*@ORM\Entity
*@ORM\Table(name="Recipees")
*/

class Recipe{

    /**
    *@ORM\Id
    *@ORM\GeneratedValue(strategy="AUTO")
    *@ORM\Column(type="integer")
    */

    protected $id;    

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipe")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
    *@ORM\Column(type="string", name="title", length=100)
    */
    private $title;

    /**
     * @ORM\Column(type="array", name="ingredients", nullable=true)
     */

    private $ingredients;
    /**
    *@ORM\Column(type="text", name="instructions")
    */

    private $instructions;

    /**
    *@ORM\Column(type="datetime", name="created_at")
    *@ORM\GeneratedValue(strategy="AUTO")
    */

    private $created_at;

    /**
    *@ORM\Column(type="datetime", name="modified_at")
    *@ORM\GeneratedValue(strategy="AUTO")
    */

    private $modified_at;

    public function __construct() {
        $this->created_at = new \DateTime();
        $this->modified_at = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        //return $this->ingredients;
        return array_values($this->ingredients);

    }

    /**
     * @param mixed $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }




    /**
     * Set instructions
     *
     * @param string $instructions
     *
     * @return Recipe
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setModifiedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }


    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return Recipe
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modified_at = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set rUser
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Recipe
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get rUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
