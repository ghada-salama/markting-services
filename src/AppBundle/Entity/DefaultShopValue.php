<?php

namespace AppBundle\Entity;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Client;
use AppBundle\Entity\header;


/**
 * Client
 *
 * @ORM\Table(name="defaultshopvalue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultShopValueRepository")
 */
class DefaultShopValue
{
  
    
        
    /**
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $brand; 
    
          
    /**
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $client; 

    
     /**
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\header")
     * @ORM\JoinColumn(name="header", referencedColumnName="id")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $header; 
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $id;

    /**
     * @var integer
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\SerializedName("shopsgpv")
     * @ORM\Column(name="shopsgpv", type="integer")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $shopsGPV;

    /**
     * @var integer
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\SerializedName("shopshq")
     * @ORM\Column(name="shopshq", type="integer")
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $shopsHQ;
 
    /**
     * @var string
     *
     * @ORM\Column(name="flag", type="boolean",nullable=true)
     * @JMSSerializer\Groups({"defult_shops_component"})
     */
    private $flag;

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
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setShopsGPV($shopsGPV)
    {
        $this->shopsGPV = $shopsGPV;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getShopsGPV()
    {
        return $this->shopsGPV;
    }

   
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setBrand(\AppBundle\Entity\Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }
 
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setClient(\AppBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }
    
        
    
  /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setHeader(\AppBundle\Entity\header $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    
        /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setShopsHQ($shopsHQ)
    {
        $this->shopsHQ = $shopsHQ;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getShopsHQ()
    {
        return $this->shopsHQ;
    }
    
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }
   
    
    
    
}
