<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OldClient
 *
 * @ORM\Table(name="old_client")
 * @ORM\Entity
 */
class OldClient
{
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ShortName", type="string", length=17, nullable=true)
     */
    private $shortname;

    /**
     * @var integer
     *
     * @ORM\Column(name="indBaja", type="smallint", nullable=true)
     */
    private $indbaja;

    /**
     * @var string
     *
     * @ORM\Column(name="SiebelCode", type="string", length=50, nullable=true)
     */
    private $siebelcode;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageFileNameV", type="string", length=150, nullable=true)
     */
    private $imagefilenamev;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageFileNameH", type="string", length=150, nullable=true)
     */
    private $imagefilenameh;

    /**
     * @var integer
     *
     * @ORM\Column(name="Orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * @var integer
     *
     * @ORM\Column(name="activateForms", type="smallint", nullable=true)
     */
    private $activateforms;

    /**
     * @var integer
     *
     * @ORM\Column(name="IDClient", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idclient;


}

