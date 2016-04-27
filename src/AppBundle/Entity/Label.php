<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Label
 *
 * @ORM\Table(name="label")
 * @ORM\Entity
 */
class Label
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
     * @ORM\Column(name="name", type="text", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Establishment", inversedBy="labels")
     * @ORM\JoinTable(name="establishment_label",
     *   joinColumns={
     *     @ORM\JoinColumn(name="label", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="establishment", referencedColumnName="id")
     *   }
     * )
     */
    private $establishment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->establishment = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Label
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
     * Add establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return Label
     */
    public function addEstablishment(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishment[] = $establishment;

        return $this;
    }

    /**
     * Remove establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     */
    public function removeEstablishment(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishment->removeElement($establishment);
    }

    /**
     * Get establishment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }
}
