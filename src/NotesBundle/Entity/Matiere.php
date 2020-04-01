<?php

namespace NotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="NotesBundle\Repository\MatiereRepository")
 */
class Matiere
{
    public function __toString()
    {
        return $this->nom;
    }

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="coefficient", type="float")
     */
    private $coefficient;

    /**
     * @var string
     *
     * @ORM\Column(name="cheffmodule", type="string", length=255)
     */
    private $cheffmodule;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Matiere
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set coefficient
     *
     * @param float $coefficient
     *
     * @return Matiere
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return float
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set cheffmodule
     *
     * @param string $cheffmodule
     *
     * @return Matiere
     */
    public function setCheffmodule($cheffmodule)
    {
        $this->cheffmodule = $cheffmodule;

        return $this;
    }

    /**
     * Get cheffmodule
     *
     * @return string
     */
    public function getCheffmodule()
    {
        return $this->cheffmodule;
    }
}

