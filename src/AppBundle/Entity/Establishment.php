<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Establishment
 *
 * @ORM\Table(name="establishment", indexes={@ORM\Index(name="id_user", columns={"id_user_owner"})})
 * @ORM\Entity
 */
class Establishment
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=200, nullable=false)
     */
    private $adress;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EstablishmentActivity", mappedBy="establishment", cascade={"remove"})
     */
    private $activities;

    /**
     * @var \AppBundle\Entity\BaseUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BaseUser", inversedBy="establishments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_owner", referencedColumnName="id")
     * })
     */
    private $userOwner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Establishment
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
     * Set description
     *
     * @param string $description
     *
     * @return Establishment
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

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Establishment
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }
        
    /**
     * Set id
     *
     * @param string $id
     *
     * @return Establishment
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Add activity
     *
     * @param \AppBundle\Entity\EstablishmentActivity $activity
     *
     * @return Establishment
     */
    public function addActivity(\AppBundle\Entity\EstablishmentActivity $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AppBundle\Entity\EstablishmentActivity $activity
     */
    public function removeActivity(\AppBundle\Entity\EstablishmentActivity $activity)
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
     * Set idUserOwner
     *
     * @param \AppBundle\Entity\BaseUser $userOwner
     *
     * @return Establishment
     */
    public function setIdUserOwner(\AppBundle\Entity\BaseUser $userOwner = null)
    {
        $this->userOwner = $userOwner;

        return $this;
    }

    /**
     * Get idUserOwner
     *
     * @return \AppBundle\Entity\BaseUser
     */
    public function getUserOwner()
    {
        return $this->userOwner;
    }
}
