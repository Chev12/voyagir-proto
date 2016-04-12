<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstablishmentActivity
 *
 * @ORM\Table(name="establishment_activity", uniqueConstraints={@ORM\UniqueConstraint(name="id_establishment_activity", columns={"id_establishment", "id_activity_type", "id"})}, indexes={@ORM\Index(name="ind_establishment_activity", columns={"id_activity_type", "id_establishment"}), @ORM\Index(name="IDX_E70DFA6865C7608B", columns={"id_establishment"}), @ORM\Index(name="IDX_E70DFA6831325DDE", columns={"id_activity_type"})})
 * @ORM\Entity
 */
class EstablishmentActivity
{
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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\ActivityType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ActivityType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_type", referencedColumnName="id")
     * })
     */
    private $activityType;

    /**
     * @var \AppBundle\Entity\Establishment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Establishment", inversedBy="activities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="establishment", referencedColumnName="id")
     * })
     */
    private $establishment;

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
     * Set id
     *
     * @param integer $id
     *
     * @return EstablishmentActivity
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
     * Set activityType
     *
     * @param \AppBundle\Entity\ActivityType $activityType
     *
     * @return EstablishmentActivity
     */
    public function setActivityType(\AppBundle\Entity\ActivityType $activityType)
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

    /**
     * Set idEstablishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return EstablishmentActivity
     */
    public function setEstablishment(\AppBundle\Entity\Establishment $establishment)
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
}
