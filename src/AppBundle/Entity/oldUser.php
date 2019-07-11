<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * oldUser
 *
 * @ORM\Table(name="old_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\oldUserRepository")
 */
class oldUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDEmpleado", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $IDEmpleado;



    /**
     * @var string
     *
     * @ORM\Column(name="NEmpleado", type="string", length=255)
     */
    private $nEmpleado;

    /**
     * @var string
     *
     * @ORM\Column(name="ApellidosNombre", type="string", length=255)
     */
    private $apellidosNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="NTUser", type="string", length=255)
     */
    private $nTUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Apellidos", type="string", length=255)
     */
    private $Apellidos;


    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;


        /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $Email;


   /**
    * @ORM\Column(name="flag", type="integer",nullable=true)
     */
    private $flag=0; 
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
     * Set flag
     *
     * @param integer $flag
     *
     * @return OldActivity
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
     * Set iDEmpleado
     *
     * @param string $iDEmpleado
     *
     * @return oldUser
     */
    public function setIDEmpleado($iDEmpleado)
    {
        $this->iDEmpleado = $iDEmpleado;

        return $this;
    }

    /**
     * Get iDEmpleado
     *
     * @return string
     */
    public function getIDEmpleado()
    {
        return $this->iDEmpleado;
    }

    /**
     * Set nEmpleado
     *
     * @param string $nEmpleado
     *
     * @return oldUser
     */
    public function setNEmpleado($nEmpleado)
    {
        $this->nEmpleado = $nEmpleado;

        return $this;
    }

    /**
     * Get nEmpleado
     *
     * @return string
     */
    public function getNEmpleado()
    {
        return $this->nEmpleado;
    }

    /**
     * Set apellidosNombre
     *
     * @param string $apellidosNombre
     *
     * @return oldUser
     */
    public function setApellidosNombre($apellidosNombre)
    {
        $this->apellidosNombre = $apellidosNombre;

        return $this;
    }

    /**
     * Get apellidosNombre
     *
     * @return string
     */
    public function getApellidosNombre()
    {
        return $this->apellidosNombre;
    }

    /**
     * Set nTUser
     *
     * @param string $nTUser
     *
     * @return oldUser
     */
    public function setNTUser($nTUser)
    {
        $this->nTUser = $nTUser;

        return $this;
    }

    /**
     * Get nTUser
     *
     * @return string
     */
    public function getNTUser()
    {
        return $this->nTUser;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return oldUser
     */
    public function setApellidos($apellidos)
    {
        $this->Apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->Apellidos;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return oldUser
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return oldUser
     */
    public function setEmail($email)
    {
        $this->Email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }
}
