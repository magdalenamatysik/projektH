<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * fridge
 *
 * @ORM\Table(name="fridge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\fridgeRepository")
 */
class fridge
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
     * @ORM\Column(name="idOwner", type="integer")
     */
    private $idOwner;


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
     * Set idOwner
     *
     * @param integer $idOwner
     *
     * @return fridge
     */
    public function setIdOwner($idOwner)
    {
        $this->idOwner = $idOwner;

        return $this;
    }

    /**
     * Get idOwner
     *
     * @return int
     */
    public function getIdOwner()
    {
        return $this->idOwner;
    }
}

