<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\jobRepository")
 */
class job
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time2", type="datetime")
     */
    private $time2;

    /**
     * @var float
     *
     * @ORM\Column(name="duration", type="float")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer")
     */
    private $idUser;
    /**
     * @var int
     *
     * @ORM\Column(name="flag", type="integer")
     */
    private $flag;

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
     * @return job
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
     * Set description
     *
     * @param string $description
     *
     * @return job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return job
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime2()
    {
        return $this->time2;
    }
    /**
     * Set time
     *
     * @param \DateTime $time2
     *
     * @return job
     */
    public function setTime2($time2)
    {
        $this->time2 = $time2;

        return $this;
    }




    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get timeday
     *
     * @return \string
     */
    public function getTimeDay()
    {

        return  $this->time->format("d");
    }

    /**
     * Get timemonth
     *
     * @return \string
     */
    public function getTimeMonth()
    {

        return  $this->time->format("m");
    }


    /**
     * Get
     *
     * @return \string
     */
    public function getTime3()
    {

        return  $this->time->format("Y-m-d G:i");
    }



    /**
     * Set duration
     *
     * @param float $duration
     *
     * @return job
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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return job
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
     * Set flag
     *
     * @param integer $flag
     *
     * @return job
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
}

