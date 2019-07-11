<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Brand
 *
 * @ORM\Table(name="lang")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LangRepository")
 */
class Lang
{
    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="brand")
     */
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Groups({"show_users","list_lang","list_users"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("name")
     * @JMSSerializer\Groups({"show_users","list_lang","list_users"})
     */
    private $name;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("shortName")
     * @ORM\Column(name="shortName", type="string", length=255)
     * @JMSSerializer\Groups({"show_users","list_lang","list_users"})
     */
    private $isoName;

 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
 
    /**
     * Set shortName
     *
     * @param string $shortName
     *
     * @return Brand
     */
    public function setIsoName($isoName)
    {
        $this->isoName = $isoName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getIsoName()
    {
        return $this->isoName;
    }

  

  
}
