<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * header
 *
 * @ORM\Table(name="header")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\headerRepository")
 */
class header
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Groups({"show_activity","show_header","defult_shops_component"})
     * 
     */
    private $id;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"activity_component"})
     * @ORM\Column(name="name", type="string", length=255)
     * @JMSSerializer\Groups({"show_activity","show_header","defult_shops_component"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="header")
     */
    private $activities;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"activity_component"})
     * @ORM\Column(name="flag", type="integer", length=255,nullable=true)
     */
    private $flag= 0;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"activity_component"})
     * @ORM\Column(name="enable", type="integer", length=255,nullable=true)
     */
    private $enable= 1;



    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="myUpdate")
     * @ORM\JoinColumn(name="lastUpdatedBy", referencedColumnName="id")
     * @JMSSerializer\Groups({"show_activities","get_add_activity"})
     */
    private $lastUpdatedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="lastUpdatedAt", type="datetime", length=255)
     */
    private $lastUpdatedAt;





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
     * @return header
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
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return header
     */
    public function addActivity(\AppBundle\Entity\Activity $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AppBundle\Entity\Activity $activity
     */
    public function removeActivity(\AppBundle\Entity\Activity $activity)
    {
        $this->activities->removeElement($activity);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set flag
     *
     * @param string $flag
     *
     * @return header
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set lastUpdatedAt
     *
     * @param \DateTime $lastUpdatedAt
     *
     * @return header
     */
    public function setLastUpdatedAt($lastUpdatedAt)
    {
        $this->lastUpdatedAt = $lastUpdatedAt;

        return $this;
    }

    /**
     * Get lastUpdatedAt
     *
     * @return \DateTime
     */
    public function getLastUpdatedAt()
    {
        return $this->lastUpdatedAt;
    }

    /**
     * Set lastUpdatedBy
     *
     * @param \AppBundle\Entity\User $lastUpdatedBy
     *
     * @return header
     */
    public function setLastUpdatedBy(\AppBundle\Entity\User $lastUpdatedBy = null)
    {
        $this->lastUpdatedBy = $lastUpdatedBy;

        return $this;
    }

    /**
     * Get lastUpdatedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getLastUpdatedBy()
    {
        return $this->lastUpdatedBy;
    }

    /**
     * Set enable
     *
     * @param integer $enable
     *
     * @return header
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return integer
     */
    public function getEnable()
    {
        return $this->enable;
    }
}
