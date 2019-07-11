<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * oldUser
 *
 * @ORM\Table(name="old_theme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\oldThemeRepository")
 */
class oldTheme
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $Name;

    /**
     * @var string
     *
     * @ORM\Column(name="IDClient", type="string", length=255)
     */
    private $IDClient;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageFileName", type="string", length=255)
     */
    private $ImageFileName;



        /**
     * @var string
     *
     * @ORM\Column(name="indBaja", type="integer", length=255)
     */
    private $indBaja;


      /**
     * @ORM\Column(name="LastUpdatedBy", type="integer",nullable=true)
     
     */
    private $LastUpdatedBy;

    /**
     * @var string
     * @ORM\Column(name="LastUpdatedDate", type="datetime", length=255,nullable=true)

     */
    private $LastUpdatedDate;



   /**
    * @ORM\Column(name="flag", type="integer",nullable=true)
     */
    private $flag=0; 
    


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
     * Set name
     *
     * @param string $name
     *
     * @return oldTheme
     */
    public function setName($name)
    {
        $this->Name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Set iDClient
     *
     * @param string $iDClient
     *
     * @return oldTheme
     */
    public function setIDClient($iDClient)
    {
        $this->IDClient = $iDClient;

        return $this;
    }

    /**
     * Get iDClient
     *
     * @return string
     */
    public function getIDClient()
    {
        return $this->IDClient;
    }

    /**
     * Set imageFileName
     *
     * @param string $imageFileName
     *
     * @return oldTheme
     */
    public function setImageFileName($imageFileName)
    {
        $this->ImageFileName = $imageFileName;

        return $this;
    }

    /**
     * Get imageFileName
     *
     * @return string
     */
    public function getImageFileName()
    {
        return $this->ImageFileName;
    }

    /**
     * Set indBaja
     *
     * @param \int $indBaja
     *
     * @return oldTheme
     */
    public function setIndBaja($indBaja)
    {
        $this->indBaja = $indBaja;

        return $this;
    }

    /**
     * Get indBaja
     *
     * @return \int
     */
    public function getIndBaja()
    {
        return $this->indBaja;
    }

    /**
     * Set lastUpdatedBy
     *
     * @param integer $lastUpdatedBy
     *
     * @return oldTheme
     */
    public function setLastUpdatedBy($lastUpdatedBy)
    {
        $this->LastUpdatedBy = $lastUpdatedBy;

        return $this;
    }

    /**
     * Get lastUpdatedBy
     *
     * @return integer
     */
    public function getLastUpdatedBy()
    {
        return $this->LastUpdatedBy;
    }

    /**
     * Set lastUpdatedDate
     *
     * @param \DateTime $lastUpdatedDate
     *
     * @return oldTheme
     */
    public function setLastUpdatedDate($lastUpdatedDate)
    {
        $this->LastUpdatedDate = $lastUpdatedDate;

        return $this;
    }

    /**
     * Get lastUpdatedDate
     *
     * @return \DateTime
     */
    public function getLastUpdatedDate()
    {
        return $this->LastUpdatedDate;
    }

    /**
     * Set flag
     *
     * @param integer $flag
     *
     * @return oldTheme
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return integer
     */
    public function getFlag()
    {
        return $this->flag;
    }
}
