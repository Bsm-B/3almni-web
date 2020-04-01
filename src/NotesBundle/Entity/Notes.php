<?php

namespace Notes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notes
 *
 * @ORM\Table(name="notes")
 * @ORM\Entity
 */
class Notes
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
     * @ORM\Column(name="formule", type="string", length=255, nullable=false)
     */
    private $formule;

    /**
     * @var integer
     *
     * @ORM\Column(name="idclasse", type="integer", nullable=false)
     */
    private $idclasse;

    /**
     * @var integer
     *
     * @ORM\Column(name="idmatiere", type="integer", nullable=false)
     */
    private $idmatiere;

    /**
     * @var integer
     *
     * @ORM\Column(name="idetudent", type="integer", nullable=false)
     */
    private $idetudent;

    /**
     * @var integer
     *
     * @ORM\Column(name="idprof", type="integer", nullable=false)
     */
    private $idprof;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="string", length=255, nullable=false)
     */
    private $remarque;


}

