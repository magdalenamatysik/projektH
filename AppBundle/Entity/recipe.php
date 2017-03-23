<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\recipeRepository")
 */
class recipe
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
	
	
    /**
     * @var int
     *
     * @ORM\Column(name="person", type="integer")
     */
    private $person;

    /**
     * @var float
     *
     * @ORM\Column(name="duration", type="float")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="idFridge", type="integer")
     */
    private $idFridge;

    /**
     * @var int
     *
     * @ORM\Column(name="flag", type="integer")
     */
    private $flag;


    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="blob")
     */
    private $foto;


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
     * @return recipe
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
     * Set person
     *
     * @param integer $person
     *
     * @return recipe
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return int
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set duration
     *
     * @param float $duration
     *
     * @return recipe
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set idFridge
     *
     * @param integer $idFridge
     *
     * @return recipe
     */
    public function setIdFridge($idFridge)
    {
        $this->idFridge = $idFridge;

        return $this;
    }

    /**
     * Get idFridge
     *
     * @return int
     */
    public function getIdFridge()
    {
        return $this->idFridge;
    }

    /**
     * Set flag
     *
     * @param integer $flag
     *
     * @return recipe
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

    

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return recipe
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }
}

