<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nr
 *
 * @ORM\Table(name="nr")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NrRepository")
 */
class Nr
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
     * @ORM\Column(name="nr", type="decimal", precision=10, scale=0)
     */
    private $nr;


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
     * @return Nr
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
     * @return Nr
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
     * Set nr
     *
     * @param string $nr
     *
     * @return Nr
     */
    public function setNr($nr)
    {
        $this->nr = $nr;

        return $this;
    }

    /**
     * Get nr
     *
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Nr
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
     * @return Nr
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
