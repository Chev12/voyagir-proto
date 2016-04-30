<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityType
 *
 * @ORM\Table(name="activity_type")
 * @ORM\Entity
 */
class ActivityType
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commitment", inversedBy="activities")
     * @ORM\JoinTable(name="activity_commitment",
     *   joinColumns={
     *     @ORM\JoinColumn(name="activity_type", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="commitment", referencedColumnName="id")
     *   }
     * )
     */
    private $commitments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commitments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ActivityType
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
     * Add commitment
     *
     * @param \AppBundle\Entity\Commitment $commitment
     *
     * @return ActivityType
     */
    public function addCommitment(\AppBundle\Entity\Commitment $commitment)
    {
        $this->commitments[] = $commitment;

        return $this;
    }

    /**
     * Remove commitment
     *
     * @param \AppBundle\Entity\Commitment $commitment
     */
    public function removeCommitment(\AppBundle\Entity\Commitment $commitment)
    {
        $this->commitments->removeElement($commitment);
    }

    /**
     * Get commitment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommitments()
    {
        return $this->commitments;
    }
}
