<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\userRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $id;

    /**
     * @ORM\Column(name="NTUser", type="integer",nullable=true)
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $NTUser;

     /**
     * @ORM\Column(name="NEmpleado", type="integer",nullable=true)
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $NEmpleado;

    /**
     * @ORM\Column(name="firstName", type="string")
     * @JMSSerializer\SerializedName("firstName")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $firstName;


    /**
     * @ORM\Column(name="lastName", type="string")
     * @JMSSerializer\SerializedName("lastName")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $lastName;


    /**
     * @ORM\Column(name="old_id", type="integer",nullable=true)
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","setting_component","show_group","show_activity"})
     */
    protected $old_id;

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Accessor(getter="getUsername")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group","show_group","show_activity"})
     */
    protected $username;

      /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Accessor(getter="getFullName")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group","show_group","show_activity","show_activities"})
     */
    protected $fullName;
    


    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Accessor(getter="getEmail")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group"})
     */
    protected $email;




    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group"})
     */
    protected $groups;


    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Accessor(getter="isAdmin")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group","show_group","show_activity"})
     */
    protected $isAdmin;

    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Accessor(getter="isHq")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group","show_group","show_activity"})
     */
    protected $isHq;


    /**
     * @var int
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Accessor(getter="isGpv")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group","show_group","show_activity"})
     */
    protected $isGpv;

    /**
     * @ORM\ManyToOne(targetEntity="Lang", inversedBy="users")
     * @ORM\JoinColumn(name="lang_id", referencedColumnName="id")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group"})
     */
    private $lang_id;

    
     /**
     * @var string
     *
     * @ORM\Column(name="household", type="boolean", nullable=true)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("boolean")
     * @JMSSerializer\SerializedName("Household")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group"})
     */
    private $Household;

    
        /**
     * @var string
     *
     * @ORM\Column(name="healthcare", type="boolean", nullable=true)
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("boolean")
     * @JMSSerializer\SerializedName("Healthcare")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group"})
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

    

    /**
      * @ORM\Column(name="flag", type="integer",nullable=true)
    */
    private $flag=0; 


    public function __construct()
    {
        $this->groups= new ArrayCollection();
      
    }


    public function getRoles()
    {
        
        $roles = [];
        if($this->groups)
        {
           
        // loop over some ManyToMany relation to a Group entity

        foreach ($this->groups as $group) {
          //  return  $group->getRoles();
            if( $group->getRoles())
            {
                $roles = array_merge($roles, $group->getRoles());
            }
            
        }
        
        return $roles;
    }
}

    /**
     * Set langId
     *
     * @param \AppBundle\Entity\Lang $langId
     *
     * @return User
     */
    public function setLangId(\AppBundle\Entity\Lang $langId = null)
    {
        $this->lang_id = $langId;

        return $this;
    }

    /**
     * Get langId
     *
     * @return \AppBundle\Entity\Lang
     */
    public function getLangId()
    {
        return $this->lang_id;
    }

    /**
     * Get langId
     *
     * @return \AppBundle\Entity\Lang
     */
    public function getIso()
    {
        if($this->lang_id)
        {
            return $this->lang_id->getIsoName();
        }
       
    }
    

    
    /**
     * Set langId
     *
     * @param \AppBundle\Entity\Lang $langId
     *
     * @return User
     */
    public function setGroups(\AppBundle\Entity\Group $g = null)
    {
        $this->groups = $g;

        return $this;
    }

  
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get groups
     *
     * @return \AppBundle\Entity\groups
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Get getUsername
     */
    public function getUsername()
    {
        return $this->username;
        //return $this->firstName .$this->lastName ;
    }
      /**
     * Get getUsername
     */
    public function getFullName()
    {
        //return $this->username;
        return $this->firstName .$this->lastName ;
    }

    
    /**
     * Get admin
     *
     * @return integer
     */
    public function isAdmin()
    {
        $isAdmin=false;
        if($this->getRoles())
        {
            $isAdmin=in_array('ROLE_SUPER_ADMIN', $this->getRoles());
           
        }
        return $isAdmin;

    }

        /**
     * Get admin
     *
     * @return integer
     */
    public function isHq()
    {
        $isAdmin=false;
        if($this->getRoles())
        {
            $isAdmin=in_array('ROLE_HQ_ADMIN', $this->getRoles());
           
        }
        return $isAdmin;
    }


        /**
     * Get admin
     *
     * @return integer
     */
    public function isGpv()
    {
        $isAdmin=false;
        if($this->getRoles())
        {
            $isAdmin=in_array('ROLE_GPV_ADMIN', $this->getRoles());
           
        }
        return $isAdmin;
      
    }



    /**
     * Set nTUser
     *
     * @param integer $nTUser
     *
     * @return User
     */
    public function setNTUser($nTUser)
    {
        $this->NTUser = $nTUser;

        return $this;
    }

    /**
     * Get nTUser
     *
     * @return integer
     */
    public function getNTUser()
    {
        return $this->NTUser;
    }

    /**
     * Set nEmpleado
     *
     * @param integer $nEmpleado
     *
     * @return User
     */
    public function setNEmpleado($nEmpleado)
    {
        $this->NEmpleado = $nEmpleado;

        return $this;
    }

    /**
     * Get nEmpleado
     *
     * @return integer
     */
    public function getNEmpleado()
    {
        return $this->NEmpleado;
    }

    /**
     * Set oldId
     *
     * @param integer $oldId
     *
     * @return User
     */
    public function setOldId($oldId)
    {
        $this->old_id = $oldId;

        return $this;
    }

    /**
     * Get oldId
     *
     * @return integer
     */
    public function getOldId()
    {
        return $this->old_id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set flag
     *
     * @param integer $flag
     *
     * @return User
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
