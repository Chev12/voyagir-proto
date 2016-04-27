<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * EstablishmentActivity
 *
 * @ORM\Table(name="establishment_activity", uniqueConstraints={@ORM\UniqueConstraint(name="establishment_order", columns={"establishment", "order"})}, indexes={@ORM\Index(name="activity_type", columns={"activity_type"}), @ORM\Index(name="establishment", columns={"establishment"})})
 * @ORM\Entity
 * @ORM\NamedQueries({
 *  @ORM\NamedQuery(name="getNewLevel",
 *              query="SELECT MAX(a.level)+1 AS new_level FROM AppBundle:EstablishmentActivity a JOIN a.establishment e WHERE e.id = :id_etb")
 * })
 */
class EstablishmentActivity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var \Establishment
     *
     * @ORM\ManyToOne(targetEntity="Establishment", inversedBy="activities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="establishment", referencedColumnName="id")
     * })
     */
    private $establishment;

    /**
     * @var \ActivityType
     *
     * @ORM\ManyToOne(targetEntity="ActivityType", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_type", referencedColumnName="id")
     * })
     */
    private $activityType;



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
     * Set description
     *
     * @param string $description
     *
     * @return EstablishmentActivity
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
     * Set price
     *
     * @param integer $price
     *
     * @return EstablishmentActivity
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return EstablishmentActivity
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return EstablishmentActivity
     */
    public function setEstablishment(\AppBundle\Entity\Establishment $establishment = null)
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * Get establishment
     *
     * @return \AppBundle\Entity\Establishment
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    /**
     * Set activityType
     *
     * @param \AppBundle\Entity\ActivityType $activityType
     *
     * @return EstablishmentActivity
     */
    public function setActivityType(\AppBundle\Entity\ActivityType $activityType = null)
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * Get activityType
     *
     * @return \AppBundle\Entity\ActivityType
     */
    public function getActivityType()
    {
        return $this->activityType;
    }
}
