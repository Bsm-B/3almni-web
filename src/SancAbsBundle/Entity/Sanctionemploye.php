<?php

namespace SancAbsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sanctionemploye
 *
 * @ORM\Table(name="sanctionemploye")
 * @ORM\Entity(repositoryClass="SancAbsBundle\Repository\SanctionemployeRepository")
 */
class Sanctionemploye
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
     *
     * @ORM\ManyToOne(targetEntity="\AlmniBundle\Entity\User")
     */
    private $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\ProfilBundle\Entity\Profilprof")
     *  @ORM\JoinColumn(name="idemploye", referencedColumnName="id")
     *
     */
    private $employe;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEmploye()
    {
        return $this->employe;
    }

    /**
     * @param mixed $employe
     */
    public function setEmploye($employe)
    {
        $this->employe = $employe;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=255)
     */
    private $nature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;


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
     * Set nature
     *
     * @param string $nature
     *
     * @return Sanctionemploye
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Sanctionemploye
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }
}

