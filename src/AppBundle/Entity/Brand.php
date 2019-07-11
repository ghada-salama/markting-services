<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 */
class Brand
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
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list","show_brand"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("name")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list","show_brand"})
     */
    private $name;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("shortName")
     * @ORM\Column(name="shortName", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list"})
     */
    private $shortName;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("brandOrder")
     * @ORM\Column(name="brandOrder", type="integer")
     * @JMSSerializer\Groups({"defult_shops_component","list_brands","show_activities_list"})
     */
    private $brandOrder;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("imageH")
     * @JMSSerializer\Accessor(getter="getImageUrl")
     * @ORM\Column(name="imageH", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"defult_shops_component","list_brands","show_activities_list"})
     */
    private $imageH;



    /**
     * @var string
     *
     * @ORM\Column(name="siebelcode", type="string", length=255,nullable=true)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\SerializedName("siebelCode")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list"})
     */
    private $siebelCode;

    


    
        
    /**
     * @var string
     *
     * @ORM\Column(name="flag", type="boolean",nullable=true)
     */
    private $flag=0;
 


       /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="Brand")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id",nullable=true)
     * @JMSSerializer\Groups({"show_activities"})

     */
    private $parent=null;

    /**
     * @ORM\OneToMany(targetEntity="Brand", mappedBy="parent")
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $children;


    /**
     * @ORM\OneToMany(targetEntity="shops", mappedBy="brand")

     */
    private $shops;

    /**
     * @JMSSerializer\Groups({"show_activities"})
     */
    private $activityShops;

    private $childrenName;



   /**
     * @var string
     * @JMSSerializer\SerializedName("image_url")
     * @JMSSerializer\Accessor(getter="getImageUrl")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_theme","show_brand"})
     */
    private $image_url;

     /**
     * @var string
     * @JMSSerializer\SerializedName("imageHExcle")
     * @JMSSerializer\Accessor(getter="getImageHExcle")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_theme","show_brand"})
     */
    private $imageHExcle;

    
 

    
        /**
     * @var string
     *
     * @ORM\Column(name="household", type="boolean", nullable=true)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("boolean")
     * @JMSSerializer\SerializedName("Household")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list"})
     */
    private $Household;

    
        /**
     * @var string
     *
     * @ORM\Column(name="healthcare", type="boolean", nullable=true)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("boolean")
     * @JMSSerializer\SerializedName("Healthcare")
     * @JMSSerializer\Groups({"show_activities","defult_shops_component","list_brands","show_activities_list"})
     */
    private $Healthcare;

    
    function getHousehold() {
        return $this->Household;
    }

    function getHealthcare() {
        return $this->Healthcare;
    }

    function setHousehold($Household) {
        $this->Household = $Household;
    }

    function setHealthcare($Healthcare) {
        $this->Healthcare = $Healthcare;
    }

    
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
     * Set name
     *
     * @param string $name
     *
     * @return Brand
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
     * Set shortName
     *
     * @param string $shortName
     *
     * @return Brand
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set brandOrder
     *
     * @param integer $brandOrder
     *
     * @return Brand
     */
    public function setBrandOrder($brandOrder)
    {
        $this->brandOrder = $brandOrder;

        return $this;
    }

    /**
     * Get brandOrder
     *
     * @return int
     */
    public function getBrandOrder()
    {
        return $this->brandOrder;
    }

    
        /**
     * Set brandOrder
     *
     * @param integer $brandOrder
     *
     * @return Brand
     */
    public function setSiebelCode($siebelCode)
    {
        $this->siebelCode = $siebelCode;

        return $this;
    }

    /**
     * Get brandOrder
     *
     * @return int
     */
    public function getSiebelCode()
    {
        return $this->siebelCode;
    }
    
    
    /**
     * Set imageH
     *
     * @param string $imageH
     *
     * @return Brand
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
        if($this->imageH)
        {
            return $this->getUploadDir().'/'.$this->imageH;
        }
       
        return null ;
        //return $this->imageH;
    }

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
     * Set imageV
     *
     * @param string $imageV
     *
     * @return Brand
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
     * @return Brand
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
     * Get subbrands
     *
     * @return integer
     */
    public function getChildren()
    {
        return $this->children;
    }

    


    public function getShops()
    {
        $this->shops;
    }
    /**
     * Get brand shops by brand id and activity id
     *
     * @return integer
     */
    public function getActivityShops($activity)
    {

        $criteria = Criteria::create()
                            ->where(Criteria::expr()->eq("activity",$activity))->setMaxResults(1);
        $res = $this->shops->matching($criteria);
        return $res->first();
    }
	
	

    /**
     * Set relParent
     *
     * @param \AppBundle\Entity\Brand $relParent
     *
     * @return Brand
     */
    public function setRelParent(\AppBundle\Entity\Brand $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get relParent
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getRelParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Brand $child
     *
     * @return Brand
     */
    public function addChild(\AppBundle\Entity\Brand $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Brand $child
     */
    public function removeChild(\AppBundle\Entity\Brand $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Add shop
     *
     * @param \AppBundle\Entity\shops $shop
     *
     * @return Brand
     */
    public function addShop(\AppBundle\Entity\shops $shop)
    {
        $this->shops[] = $shop;

        return $this;
    }

    /**
     * Remove shop
     *
     * @param \AppBundle\Entity\shops $shop
     */
    public function removeShop(\AppBundle\Entity\shops $shop)
    {
        $this->shops->removeElement($shop);
    }


    /**
     * Get subbrands
     *
     * @return integer
     */
    public function getChildrenName($prefix)
    {
        $brands=$this->children; //return subbrands 
        $childrenName=[];
        $childrenName[$prefix."shops"]=""  ; 
        foreach ($brands as $key => $brand) {
            //$childrenName[]=$prefix.$brand->getId(); 
            $childrenName[$prefix.$brand->getId()]=""  ;    //   
        }
        return  $childrenName;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Brand $parent
     *
     * @return Brand
     */
    public function setParent(\AppBundle\Entity\Brand $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getParent()
    {
        return $this->parent;
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
       // dump( $this->getUploadDir().'/'.$this->imageH);die;
        if($this->imageH!=null)
        {
           // die("dsds");
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
       // return $imageProvider;

    }

        /**
     * Get imageUrl
     *
     * @return string
     */
    // public function getImageUrl()
    // {
    //     if($this->imageH)
    //     {
    //         return $this->getUploadDir().'/'.$this->imageH;
    //     }
       
    //     return null ;
    // }

    // public function getUploadDir()
    // {
    //     global $kernel;
    //     $imageProvider = $kernel->getContainer()->getParameter('images_directory_upload');

    //     $imageProvider = str_replace('\\', '/', $imageProvider);
    //     return $imageProvider;
      
    // }
}
