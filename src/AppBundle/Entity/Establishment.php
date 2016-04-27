<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Establishment
 *
 * @ORM\Table(name="establishment", indexes={@ORM\Index(name="id_user", columns={"user_owner"}), @ORM\Index(name="category_inf_category_sup", columns={"category_inf", "category_sup"})})
 * @ORM\Entity
 */
class Establishment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_inf", referencedColumnName="limit_inf"),
     *   @ORM\JoinColumn(name="category_sup", referencedColumnName="limit_sup")
     * })
     */
    private $category;

    /**
     * @var \BaseUser
     *
     * @ORM\ManyToOne(targetEntity="BaseUser", inversedBy="establishments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_owner", referencedColumnName="id")
     * })
     */
    private $userOwner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Label", mappedBy="establishment")
     */
    private $labels;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EstablishmentActivity", mappedBy="establishment", cascade={"remove"})
     */
    protected $activities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->label = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Establishment
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set userOwner
     *
     * @param \AppBundle\Entity\BaseUser $userOwner
     *
     * @return Establishment
     */
    public function setUserOwner(\AppBundle\Entity\BaseUser $userOwner = null)
    {
        $this->userOwner = $userOwner;

        return $this;
    }

    /**
     * Get userOwner
     *
     * @return \AppBundle\Entity\BaseUser
     */
    public function getUserOwner()
    {
        return $this->userOwner;
    }

    /**
     * Add label
     *
     * @param \AppBundle\Entity\Label $label
     *
     * @return Establishment
     */
    public function addLabel(\AppBundle\Entity\Label $label)
    {
        $this->label[] = $label;

        return $this;
    }

    /**
     * Remove label
     *
     * @param \AppBundle\Entity\Label $label
     */
    public function removeLabel(\AppBundle\Entity\Label $label)
    {
        $this->label->removeElement($label);
    }

    /**
     * Get labels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLabels()
    {
        return $this->labels;
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
}
