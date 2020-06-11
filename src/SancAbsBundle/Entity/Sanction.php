<?php

namespace SancAbsBundle\Entity;

use AlmniBundle\AlmniBundle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Sanction
 *
 * @ORM\Table(name="sanction", indexes={@ORM\Index(name="IDX_6D6491AF3AA469EE", columns={"ideleve"})})
 * @ORM\Entity
 */
class Sanction
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
     *
     * @ORM\ManyToOne(targetEntity="\AlmniBundle\Entity\User")
     */
    private $user;

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
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=255, nullable=false)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "le commentaire doit comporter au moins 3 caractères",
     *      maxMessage = "le commentaire ne doit pas dépasser les {{limit}} 50 caractères"
     * )
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\ProfilBundle\Entity\Profileleve")
     *   @ORM\JoinColumn(name="ideleve", referencedColumnName="id")
     *
     */
    private $eleve;



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
     * Set nature
     *
     * @param string $nature
     *
     * @return Sanction
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Sanction
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Sanction
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


}
