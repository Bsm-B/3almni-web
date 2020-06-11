<?php

namespace ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profileleve
 *
 * @ORM\Table(name="profileleve")
 * @ORM\Entity(repositoryClass="ProfilBundle\Repository\ProfileleveRepository")
 */
class Profileleve
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenaiss", type="date")
     */
    private $datenaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\SancAbsBundle\Entity\Classe")
     * @ORM\JoinColumn(name="idclasse", referencedColumnName="id")
     *
     */
    private $classe;

    /**
     * @return mixed
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param mixed $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @var /Profilparent
     * @ORM\ManyToOne(targetEntity="Profilparent")
     *   @ORM\JoinColumn(name="idparent", referencedColumnName="id")
     *
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="branche", type="string", length=255)
     */
    private $branche;

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }


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
     * @return Profileleve
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Profileleve
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Profileleve
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set datenaiss
     *
     * @param \DateTime $datenaiss
     *
     * @return Profileleve
     */
    public function setDatenaiss($datenaiss)
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    /**
     * Get datenaiss
     *
     * @return \DateTime
     */
    public function getDatenaiss()
    {
        return $this->datenaiss;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Profileleve
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }



    /**
     * Set branche
     *
     * @param string $branche
     *
     * @return Profileleve
     */
    public function setBranche($branche)
    {
        $this->branche = $branche;

        return $this;
    }

    /**
     * Get branche
     *
     * @return string
     */
    public function getBranche()
    {
        return $this->branche;
    }
}

