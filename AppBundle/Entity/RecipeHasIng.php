<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeHasIng
 *
 * @ORM\Table(name="recipe_has_ing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeHasIngRepository")
 */
class RecipeHasIng
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idRecipe", type="integer")
     */
    private $idRecipe;

    /**
     * @var int
     *
     * @ORM\Column(name="idIng", type="integer")
     */
    private $idIng;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idRecipe
     *
     * @param integer $idRecipe
     *
     * @return RecipeHasIng
     */
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

    /**
     * Get idRecipe
     *
     * @return int
     */
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    /**
     * Set idIng
     *
     * @param integer $idIng
     *
     * @return RecipeHasIng
     */
    public function setIdIng($idIng)
    {
        $this->idIng = $idIng;

        return $this;
    }

    /**
     * Get idIng
     *
     * @return int
     */
    public function getIdIng()
    {
        return $this->idIng;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return RecipeHasIng
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }
}

