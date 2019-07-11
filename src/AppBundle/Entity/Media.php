<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia as basemedia;
use JMS\Serializer\Annotation as JMSSerializer;
/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 */
class Media extends basemedia {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")

     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"activity_all","activity","itineraryEdit","activityEdit"})
     */
    protected $id;
    /**
     * @ORM\Column(name="x",type="float",nullable=true)
     */
    private $x;

    /**
     * @ORM\Column(name="y",type="float",nullable=true)
     */
    private $y;
    /**
     * @ORM\Column(name="x2",type="float",nullable=true)
     */
    private $x2;

    /**
     * @ORM\Column(name="y2",type="float",nullable=true)
     */
    private $y2;
    /**
     * @ORM\Column(name="ratio",type="float",nullable=true)
     */
    private $ratio;

    /**
     * @ORM\Column(name="axis",type="string",nullable=true)
     */
    private $axis;
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="parent_media", referencedColumnName="id",nullable=true, onDelete="CASCADE")
     */
    private $parentCrop;
    /**
     * @var Cropped
     * @ORM\Column(name="cropped",type="boolean")
     */
    private $cropped = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="is_used", type="boolean")
     */
    private $isUsed = false;

    public function getId() {
        return $this->id;
    }
    /**
     *
     * @JMSSerializer\VirtualProperty
     * @JMSSerializer\SerializedName("url")
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"current_user"})
     *
     * @return string
     */
    public function getMediumUrl() {
        global $kernel;

        $imageProvider = $kernel->getContainer()->get('sonata.media.provider.image');
        if($this->getContext() == 'profile'){
           return $imageProvider->generatePublicUrl($this, 'profile_medium',true);
         }
        if($this->getContext() == 'itinerary'){
            return $imageProvider->generatePublicUrl($this, 'itinerary_card',true);
        }
        if($this->getContext() == 'cover'){
            return $imageProvider->generatePublicUrl($this, 'cover_large',true);
        }
        if($this->getContext() == 'sponser'){
            return $imageProvider->generatePublicUrl($this, 'sponser_large',true);
        }
        return $imageProvider->generatePublicUrl($this, 'default_card',true);
    }
    /**
     *
     * @JMSSerializer\VirtualProperty
     * @JMSSerializer\SerializedName("url")
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"itineraryReviews","public_user","itineraryPremium"})
     *
     * @return string
     */
    public function getLargeUrl() {
        global $kernel;

        $imageProvider = $kernel->getContainer()->get('sonata.media.provider.image');
        $fileProvider = $kernel->getContainer()->get('sonata.media.provider.file');
        if($this->getContext() == 'profile'){
           return $imageProvider->generatePublicUrl($this, 'profile_large',true);
         }
        if($this->getContext() == 'itinerary'){
            return $imageProvider->generatePublicUrl($this, 'itinerary_card',true);
        }
        if($this->getContext() == 'cover'){
            return $imageProvider->generatePublicUrl($this, 'cover_large',true);
        }
        if($this->getContext() == 'video'){
            // return $fileProvider->generatePublicUrl($this, 'video_reference',true);
            return $fileProvider->generatePublicUrl($this,'reference');
        }
        if($this->getContext() == 'sponser'){
            return $imageProvider->generatePublicUrl($this, 'sponser_large',true);
        }
        return $imageProvider->generatePublicUrl($this, 'default_card',true);
    }

   /**
     *
     * @JMSSerializer\VirtualProperty
     * @JMSSerializer\SerializedName("url")
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"view_activity","image","activity_all","activity","dashboard","serach_guide_component"})
     *
     * @return string
     */
    public function getUrlMethod() {
        global $kernel;

        $imageProvider = $kernel->getContainer()->get('sonata.media.provider.image');
        $fileProvider = $kernel->getContainer()->get('sonata.media.provider.file');
        if($this->getContext() == 'profile'){
            return $imageProvider->generatePublicUrl($this, 'profile_large',true);
        }
        if($this->getContext() == 'itinerary'){
            return $imageProvider->generatePublicUrl($this, 'itinerary_card',true);
        }
        if($this->getContext() == 'video'){
           // return $fileProvider->generatePublicUrl($this, 'video_reference',true);
            return $fileProvider->generatePublicUrl($this,'reference');
        }
        if($this->getContext() == 'sponser'){
            return $imageProvider->generatePublicUrl($this, 'sponser_large',true);
        }
        return $imageProvider->generatePublicUrl($this, 'default_card',true);
    }


    /**
     *
     * @JMSSerializer\VirtualProperty
     * @JMSSerializer\SerializedName("url")
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"itineraryEdit","activityEdit"})
     */
    public function getSourceUrlMethod() {
        global $kernel;

        $imageProvider = $kernel->getContainer()->get('sonata.media.provider.file');

        return $imageProvider->generatePublicUrl($this, 'reference',true);
    }

    /**
     * Set isUsed
     *
     * @param boolean $isUsed
     *
     * @return Media
     */
    public function setIsUsed($isUsed) {
        $this->isUsed = $isUsed;

        return $this;
    }

    /**
     * Get isUsed
     *
     * @return boolean
     */
    public function getIsUsed() {
        return $this->isUsed;
    }


    /**
     * Set x
     *
     * @param float $x
     *
     * @return Media
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param float $y
     *
     * @return Media
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set ratio
     *
     * @param float $ratio
     *
     * @return Media
     */
    public function setRatio($ratio)
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * Get ratio
     *
     * @return float
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * Set cropped
     *
     * @param boolean $cropped
     *
     * @return Media
     */
    public function setCropped($cropped)
    {
        $this->cropped = $cropped;

        return $this;
    }

    /**
     * Get cropped
     *
     * @return boolean
     */
    public function getCropped()
    {
        return $this->cropped;
    }

    /**
     * Set parentCrop
     *
     * @param \AppBundle\Entity\Media $parentCrop
     *
     * @return Media
     */
    public function setParentCrop(\AppBundle\Entity\Media $parentCrop = null)
    {
        $this->parentCrop = $parentCrop;

        return $this;
    }

    /**
     * Get parentCrop
     *
     * @return \AppBundle\Entity\Media
     */
    public function getParentCrop()
    {
        return $this->parentCrop;
    }

    /**
     * Set x2
     *
     * @param float $x2
     *
     * @return Media
     */
    public function setX2($x2)
    {
        $this->x2 = $x2;

        return $this;
    }

    /**
     * Get x2
     *
     * @return float
     */
    public function getX2()
    {
        return $this->x2;
    }

    /**
     * Set y2
     *
     * @param float $y2
     *
     * @return Media
     */
    public function setY2($y2)
    {
        $this->y2 = $y2;

        return $this;
    }

    /**
     * Get y2
     *
     * @return float
     */
    public function getY2()
    {
        return $this->y2;
    }

    /**
     * Set axis
     *
     * @param string $axis
     *
     * @return Media
     */
    public function setAxis($axis)
    {
        $this->axis = $axis;

        return $this;
    }

    /**
     * Get axis
     *
     * @return string
     */
    public function getAxis()
    {
        if($this->getCropped() && !$this->axis){
            $data =array();
            $data['x'] = $this->getX();
            $data['x2'] = $this->getX2();
            $data['y'] = $this->getY();
            $data['y2'] = $this->getY2();
            $this->axis = json_encode($data);
        }
        return $this->axis;
    }
}
