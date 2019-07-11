<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OldBrand
 *
 * @ORM\Table(name="old_brand")
 * @ORM\Entity
 */

 /**
 * Offer_Quality
 *
 * @ORM\Table(name="old_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OldBrandRepository")
 */

class OldBrand
{
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=100, nullable=true)
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
     * @ORM\Column(name="SiebelCode", type="string", length=100, nullable=true)
     */
    private $siebelcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Orden", type="smallint", nullable=false)
     */
    private $orden;

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
     * @ORM\Column(name="idForm", type="integer", nullable=true)
     */
    private $idform;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops0", type="string", length=50, nullable=false)
     */
    private $nshops0;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops1", type="string", length=50, nullable=false)
     */
    private $nshops1;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops2", type="string", length=50, nullable=false)
     */
    private $nshops2;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops3", type="string", length=50, nullable=false)
     */
    private $nshops3;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops4", type="string", length=50, nullable=false)
     */
    private $nshops4;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops5", type="string", length=50, nullable=false)
     */
    private $nshops5;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops6", type="string", length=50, nullable=false)
     */
    private $nshops6;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops7", type="string", length=50, nullable=false)
     */
    private $nshops7;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops8", type="string", length=50, nullable=false)
     */
    private $nshops8;

    /**
     * @var string
     *
     * @ORM\Column(name="NShops9", type="string", length=50, nullable=false)
     */
    private $nshops9;

    /**
     * @var integer
     *
     * @ORM\Column(name="IDBrand", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbrand;


}

