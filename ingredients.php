<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ingredients
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ingredientsRepository")
 */
class ingredients
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
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="kcal", type="integer")
     */
    private $kcal;

    /**
     * @var float
     *
     * @ORM\Column(name="carbohydrates", type="float")
     */
    private $carbohydrates;

    /**
     * @var float
     *
     * @ORM\Column(name="protein", type="float")
     */
    private $protein;

    /**
     * @var float
     *
     * @ORM\Column(name="fat", type="float")
     */
    private $fat;


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
     * Set name
     *
     * @param string $name
     *
     * @return ingredients
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set kcal
     *
     * @param integer $kcal
     *
     * @return ingredients
     */
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;

        return $this;
    }

    /**
     * Get kcal
     *
     * @return int
     */
    public function getKcal()
    {
        return $this->kcal;
    }

    /**
     * Set carbohydrates
     *
     * @param float $carbohydrates
     *
     * @return ingredients
     */
    public function setCarbohydrates($carbohydrates)
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    /**
     * Get carbohydrates
     *
     * @return float
     */
    public function getCarbohydrates()
    {
        return $this->carbohydrates;
    }

    /**
     * Set protein
     *
     * @param float $protein
     *
     * @return ingredients
     */
    public function setProtein($protein)
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * Get protein
     *
     * @return float
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * Set fat
     *
     * @param float $fat
     *
     * @return ingredients
     */
    public function setFat($fat)
    {
        $this->fat = $fat;

        return $this;
    }

    /**
     * Get fat
     *
     * @return float
     */
    public function getFat()
    {
        return $this->fat;
    }
}

