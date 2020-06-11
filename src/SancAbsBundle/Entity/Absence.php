<?php

namespace SancAbsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence", indexes={@ORM\Index(name="IDX_765AE0C93AA469EE", columns={"ideleve"}), @ORM\Index(name="IDX_765AE0C94F100524", columns={"idmatiere"}), @ORM\Index(name="IDX_765AE0C9EB3A123A", columns={"idclasse"})})
 * @ORM\Entity
 */
class Absence
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
     *
     * @ORM\ManyToOne(targetEntity="\ProfilBundle\Entity\Profileleve")
     * @ORM\JoinColumn(name="ideleve", referencedColumnName="id")
     *
     */
    private $eleve;

    /**
     * @return mixed
     */
    public function getEleve()
    {
        return $this->eleve;
    }

    /**
     * @param mixed $eleve
     */
    public function setEleve($eleve)
    {
        $this->eleve = $eleve;
    }

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclasse", referencedColumnName="id")
     * })
     */
    private $classe;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmatiere", referencedColumnName="id")
     * })
     */
    private $matiere;



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
     * @return Absence
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
     * @return \Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param \Classe $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @return \Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @param \Matiere $matiere
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;
    }

}
