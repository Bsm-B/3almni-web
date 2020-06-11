<?php

namespace SancAbsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Absenceemploye
 *
 * @ORM\Table(name="absenceemploye", indexes={@ORM\Index(name="IDX_8B323A49270081D7", columns={"idemploye"})})
 * @ORM\Entity
 */
class Absenceemploye
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateabsence", type="datetime", nullable=false)
     */
    private $dateabsence;

    /**
     * @var integer
     *
     *@Assert\NotNull(message="Saisir Nombre d'heures")
     * @ORM\Column(name="nbrheure", type="integer", nullable=false)
     */
    private $nbrheure;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\ProfilBundle\Entity\Profilprof")
     *  @ORM\JoinColumn(name="idemploye", referencedColumnName="id")
     *
     */
    private $employe;



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
     * Set dateabsence
     *
     * @param \DateTime $dateabsence
     *
     * @return Absenceemploye
     */
    public function setDateabsence($dateabsence)
    {
        $this->dateabsence = $dateabsence;

        return $this;
    }

    /**
     * Get dateabsence
     *
     * @return \DateTime
     */
    public function getDateabsence()
    {
        return $this->dateabsence;
    }

    /**
     * Set nbrheure
     *
     * @param integer $nbrheure
     *
     * @return Absenceemploye
     */
    public function setNbrheure($nbrheure)
    {
        $this->nbrheure = $nbrheure;

        return $this;
    }

    /**
     * Get nbrheure
     *
     * @return integer
     */
    public function getNbrheure()
    {
        return $this->nbrheure;
    }

    /**
     * @return \Profilprof
     */
    public function getEmploye()
    {
        return $this->employe;
    }

    /**
     * @param \Profilprof $employe
     */
    public function setEmploye($employe)
    {
        $this->employe = $employe;
    }


}
