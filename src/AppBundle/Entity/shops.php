<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * shops_hq
 *
 * @ORM\Table(name="shops")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\shopsRepository")
 */
class shops
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
     * @ORM\Column(name="shops_hq", type="decimal", precision=10, scale=0,nullable=true)
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $shopsHqValue;

    /**
     * @var string
     *
     * @ORM\Column(name="shops_gpv", type="decimal", precision=10, scale=0,nullable=true)
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $shopsGpvValue;

    /**
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="shops")
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $activity;

    /**

     * @JMSSerializer\Groups({"show_activities"})
     */
    private $myActivityId;


    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="shops")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="PercentComplaint", type="decimal", precision=10, scale=0,nullable=true)
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $PercentComplaint;
    
    function getPercentComplaint() {
        return $this->PercentComplaint;
    }

    function setPercentComplaint($PercentComplaint) {
        $this->PercentComplaint = $PercentComplaint;
    }

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
     * Set shopsHqValue
     *
     * @param string $shopsHqValue
     *
     * @return shops
     */
    public function setShopsHqValue($shopsHqValue)
    {
        $this->shopsHqValue = $shopsHqValue;

        return $this;
    }

    /**
     * Get shopsHqValue
     *
     * @return string
     */
    public function getShopsHqValue()
    {
        return $this->shopsHqValue;
    }

    /**
     * Set shopsGpvValue
     *
     * @param string $shopsGpvValue
     *
     * @return shops
     */
    public function setShopsGpvValue($shopsGpvValue)
    {
        $this->shopsGpvValue = $shopsGpvValue;

        return $this;
    }

    /**
     * Get shopsGpvValue
     *
     * @return string
     */
    public function getShopsGpvValue()
    {
        return $this->shopsGpvValue;
    }

    /**
     * Set activityId
     *
     * @param \AppBundle\Entity\Activity $activityId
     *
     * @return shops
     */
    public function setActivityId(\AppBundle\Entity\Activity $activityId = null)
    {
        $this->activity_id = $activityId;

        return $this;
    }

    /**
     * Get activityId
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivityId()
    {
        return $this->activity->id;
    }

    /**
     * Get activityId
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getMyActivityId()
    {
        return $this->myActivityId;
    }

    

    /**
     * Set activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return shops
     */
    public function setActivity(\AppBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     *
     * @return shops
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
