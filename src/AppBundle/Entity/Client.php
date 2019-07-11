<?php

namespace AppBundle\Entity;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client
{
    
    
    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="client")
     */
    private $activities;

     /**
     * @var Theme[]
     * @JMSSerializer\Type("array<Theme>")
     * @JMSSerializer\Expose
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Theme", mappedBy="client")
     */
    private $themes;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"show_activities","get_add_activity","defult_shops_component","list_client","show_client"})
     */
    private $id;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("name")
     * @ORM\Column(name="name", type="string", length=255)
     * @JMSSerializer\Groups({"show_activity","show_activities","get_add_activity","defult_shops_component","show_activities_list","list_client","show_client"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("plantTo")
     * @JMSSerializer\Groups({"show_activities","get_add_activity","defult_shops_component","list_client","show_activities_list"})
     * @ORM\Column(name="plantTo", type="string", length=255,nullable=true)
     */
    private $plantTo;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("clientOrder")
     * @ORM\Column(name="clientOrder", type="integer")
     * @Assert\NotBlank()
     * @JMSSerializer\Groups({"defult_shops_component","list_client","show_activities_list"})
     */
    private $clientOrder;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("formActivated")
     * @ORM\Column(name="formActivated", type="integer",nullable=true)
     */
    private $formActivated;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("imageH")
     * @JMSSerializer\Accessor(getter="getImageUrl")
     * @ORM\Column(name="imageH", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"show_activities","get_add_activity","defult_shops_component","list_client","show_activities_list"})
     */
    private $imageH;

  
    
    /**
     * @var string
     *
     * @ORM\Column(name="flag", type="boolean",nullable=true)
     */
    private $flag=0;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\SerializedName("maxShops")
     * @ORM\Column(name="maxShops", type="integer",nullable=true)
     * @JMSSerializer\Groups({"show_activities","get_add_activity","defult_shops_component","list_client","show_activities_list"})
     */
    private $maxShops;


   /**
     * @var string
     * @JMSSerializer\SerializedName("image_url")
     * @JMSSerializer\Accessor(getter="getImageUrl")
     * @JMSSerializer\Groups({"show_activities","get_add_activity","defult_shops_component","show_activities_list","list_client","show_client"})
     */
    private $imageUrl;


    /**
     * @var string
     * @JMSSerializer\SerializedName("imageHExcle")
     * @JMSSerializer\Accessor(getter="getImageHExcle")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_theme","show_brand"})
     */
    private $imageHExcle;



     /**
     * Get imageH
     *
     * @return string
     */
    public function getImageHExcle()
    
    {
        
        global $kernel;
       // $imageProvider = $kernel->getContainer()->getParameter('live_host_upload_path');
        $imageProvider = $kernel->getContainer()->getParameter('images_directory_upload');
        $imageProvider = str_replace('\\', '/', $imageProvider);

        if($this->imageH)
        {
           // return $imageProvider='http://livesoa.rbnse.pro/backend/web/uploads/gallery/AhorramasH.jpg';
            return $imageProvider.strtolower($this->imageH);
        }
       
        return null ;
        //return $this->imageH;
    }


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
    
    /**
     * Set plantTo
     *
     * @param string $plantTo
     *
     * @return Client
     */
    public function setPlantTo($plantTo)
    {
        $this->plantTo = $plantTo;

        return $this;
    }

    /**
     * Get plantTo
     *
     * @return string
     */
    public function getPlantTo()
    {
        return $this->plantTo;
    }

    /**
     * Set clientOrder
     *
     * @param integer $clientOrder
     *
     * @return Client
     */
    public function setClientOrder($clientOrder)
    {
        $this->clientOrder = $clientOrder;

        return $this;
    }

    /**
     * Get clientOrder
     *
     * @return int
     */
    public function getClientOrder()
    {
        return $this->clientOrder;
    }

    /**
     * Set formActivated
     *
     * @param integer $formActivated
     *
     * @return Client
     */
    public function setFormActivated($formActivated)
    {
        $this->formActivated = $formActivated;

        return $this;
    }

    /**
     * Get formActivated
     *
     * @return int
     */
    public function getFormActivated()
    {
        return $this->formActivated;
    }

    /**
     * Set imageH
     *
     * @param string $imageH
     *
     * @return Client
     */
    public function setImageH($imageH)
    {
        $this->imageH = $imageH;

        return $this;
    }

    /**
     * Get imageH
     *
     * @return string
     */
    public function getImageH()
    {
        //return $this->imageH;
        if($this->imageH)
        {
            return $this->getUploadDir().'/'.$this->imageH;
        }
       
        return null ;
    }

    /**
     * Set imageV
     *
     * @param string $imageV
     *
     * @return Client
     */
    public function setImageV($imageV)
    {
        $this->imageV = $imageV;

        return $this;
    }

    /**
     * Get imageV
     *
     * @return string
     */
    public function getImageV()
    {
        return $this->imageV;
    }

    /**
     * Add activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return Client
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
     * Add theme
     *
     * @param \AppBundle\Entity\Theme $theme
     *
     * @return Client
     */
    public function addTheme(\AppBundle\Entity\Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * Remove theme
     *
     * @param \AppBundle\Entity\Theme $theme
     */
    public function removeTheme(\AppBundle\Entity\Theme $theme)
    {
        $this->themes->removeElement($theme);
    }

    /**
     * Get themes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Client
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set maxShops
     *
     * @param integer $maxShops
     *
     * @return Client
     */
    public function setMaxShops($maxShops)
    {
        $this->maxShops = $maxShops;

        return $this;
    }

    /**
     * Get maxShops
     *
     * @return integer
     */
    public function getMaxShops()
    {
        return $this->maxShops;
    }

        /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Theme
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        if($this->imageH)
        {
            return $this->getUploadDir().'/'.strtolower($this->imageH);
        }
       
        return null ;
    }

    public function getUploadDir()
    {
        global $kernel;
        $imageProvider = $kernel->getContainer()->getParameter('live_host_upload_path');

        $imageProvider = str_replace('\\', '/', $imageProvider);
		//$imageProvider = "http://soa.rbnse.pro/backend/web/uploads/gallery/";
        return $imageProvider;
       // return $imageProvider->generatePublicUrl($this,"default_card",true);

        //$imageProvider = $kernel->getContainer()->get('sonata.media.provider.image');
        //return $imageProvider->generatePublicUrl($media, 'default_card',true);


        //$imageProvider = $kernel->getContainer()->get('app.app.service');
        //return $imageProvider->getBasePath();

        //$imageProvider = $kernel->getContainer()->get('sonata.media.provider.image');
        //return $imageProvider->generatePublicUrl($media, 'default_card',true);
        // return  $this->get('app.app.service')->getBasePath();
    }
}
