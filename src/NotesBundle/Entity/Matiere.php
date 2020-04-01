<?php

namespace Notes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity
 */
class Matiere
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="coefficient", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefficient;

    /**
     * @var string
     *
     * @ORM\Column(name="cheffmodule", type="string", length=255, nullable=false)
     */
    private $cheffmodule;


}

