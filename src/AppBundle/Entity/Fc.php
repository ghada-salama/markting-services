<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fc
 *
 * @ORM\Table(name="fc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FcRepository")
 */
class Fc
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
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="activities")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;



    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="activities")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;


    /**
     * @var int
     *
     * @ORM\Column(name="wYear", type="integer")
     */
    private $wYear;

    /**
     * @var int
     *
     * @ORM\Column(name="wMonth", type="integer")
     */
    private $wMonth;

    /**
     * @var int
     *
     * @ORM\Column(name="fc", type="decimal", precision=10, scale=0)
     */
    private $fc;


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
     * Set wYear
     *
     * @param integer $wYear
     *
     * @return Fc
     */
    public function setWYear($wYear)
    {
        $this->wYear = $wYear;

        return $this;
    }

    /**
     * Get wYear
     *
     * @return integer
     */
    public function getWYear()
    {
        return $this->wYear;
    }

    /**
     * Set wMonth
     *
     * @param integer $wMonth
     *
     * @return Fc
     */
    public function setWMonth($wMonth)
    {
        $this->wMonth = $wMonth;

        return $this;
    }

    /**
     * Get wMonth
     *
     * @return integer
     */
    public function getWMonth()
    {
        return $this->wMonth;
    }

    /**
     * Set fc
     *
     * @param string $fc
     *
     * @return Fc
     */
    public function setFc($fc)
    {
        $this->fc = $fc;

        return $this;
    }

    /**
     * Get fc
     *
     * @return string
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Fc
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     *
     * @return Fc
     */
    public function setBrand(\AppBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }
}
