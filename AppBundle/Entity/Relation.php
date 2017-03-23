<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RelationRepository")
 */
class Relation
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
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user2", type="integer")
     */
    private $idUser2;

    /**
     * @var int
     *
     * @ORM\Column(name="accept", type="integer")
     */
    private $accept;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Relation
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idUser2
     *
     * @param integer $idUser2
     *
     * @return Relation
     */
    public function setIdUser2($idUser2)
    {
        $this->idUser2 = $idUser2;

        return $this;
    }

    /**
     * Get idUser2
     *
     * @return int
     */
    public function getIdUser2()
    {
        return $this->idUser2;
    }

    /**
     * Set accept
     *
     * @param integer $accept
     *
     * @return Relation
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Get accept
     *
     * @return int
     */
    public function getAccept()
    {
        return $this->accept;
    }
}

