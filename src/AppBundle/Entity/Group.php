<?php
// src/AppBundle/Entity/Group.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\GroupRepository")
 */
class Group extends BaseGroup
{



    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Groups({"list_users","show_users","show_group","show_user_group"})
     */
     protected $id;
     

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Accessor(getter="getName",setter="setName")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","show_group"})
     */
    protected $name;

    
    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Accessor(getter="getName",setter="setName")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","show_group"})
     */
    protected $description;


    

    /**
     * @var string
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @ORM\Column(name="observaciones", type="text")
     * @JMSSerializer\Groups({"list_users","show_users","show_user_group","show_group"})
     */
    protected $observaciones;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="groups")

     * @JMSSerializer\Groups({"show_user_group","show_group"})
     */
    protected $users;

    /**
     * @var string
     *
     * @ORM\Column(name="flag", type="boolean",nullable=true)
     */
    private $flag=0;

    public function __construct()
    {
          // guarantees that a user always has at least one role for security

        $this->roles[]='ROLE_USER';

      
    }
 


    /**
     * Set flag
     *
     * @param integer $flag
     *
     * @return Group
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

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }


    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Group
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
