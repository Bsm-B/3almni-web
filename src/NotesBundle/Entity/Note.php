<?php

namespace NotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="NotesBundle\Repository\NoteRepository")
 */
class Note
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
     * @ORM\Column(name="formule", type="string", length=255)
     */
    private $formule;

    /**
     * @var int
     *
     * @ORM\Column(name="idclasse", type="integer")
     */
    private $idclasse;


    /**
     * @ManyToOne(targetEntity="Matiere")
     * @JoinColumn(name="idmatiere", referencedColumnName="id")
     */
    private $idmatiere;

    /**
     * @var int
     *
     * @ORM\Column(name="idetudent", type="integer")
     */
    private $idetudent;

    /**
     * @var int
     *
     * @ORM\Column(name="idprof", type="integer")
     */
    private $idprof;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="string", length=255)
     */
    private $remarque;


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
     * Set formule
     *
     * @param string $formule
     *
     * @return Note
     */
    public function setFormule($formule)
    {
        $this->formule = $formule;

        return $this;
    }

    /**
     * Get formule
     *
     * @return string
     */
    public function getFormule()
    {
        return $this->formule;
    }

    /**
     * Set idclasse
     *
     * @param integer $idclasse
     *
     * @return Note
     */
    public function setIdclasse($idclasse)
    {
        $this->idclasse = $idclasse;

        return $this;
    }

    /**
     * Get idclasse
     *
     * @return int
     */
    public function getIdclasse()
    {
        return $this->idclasse;
    }

    /**
     * Set idmatiere
     *
     * @param integer $idmatiere
     *
     * @return Note
     */
    public function setIdmatiere($idmatiere)
    {
        $this->idmatiere = $idmatiere;

        return $this;
    }

    /**
     * Get idmatiere
     *
     * @return int
     */
    public function getIdmatiere()
    {
        return $this->idmatiere;
    }

    /**
     * Set idetudent
     *
     * @param integer $idetudent
     *
     * @return Note
     */
    public function setIdetudent($idetudent)
    {
        $this->idetudent = $idetudent;

        return $this;
    }

    /**
     * Get idetudent
     *
     * @return int
     */
    public function getIdetudent()
    {
        return $this->idetudent;
    }

    /**
     * Set idprof
     *
     * @param integer $idprof
     *
     * @return Note
     */
    public function setIdprof($idprof)
    {
        $this->idprof = $idprof;

        return $this;
    }

    /**
     * Get idprof
     *
     * @return int
     */
    public function getIdprof()
    {
        return $this->idprof;
    }

    /**
     * Set note
     *
     * @param float $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Note
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }
}

