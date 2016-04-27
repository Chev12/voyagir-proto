<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commitment
 *
 * @ORM\Table(name="commitment")
 * @ORM\Entity
 */
class Commitment
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
     * @ORM\Column(name="icon", type="string", length=255, nullable=false)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ActivityType", mappedBy="commitments")
     */
    private $activityType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="commitment")
     * @ORM\JoinTable(name="category_commitment",
     *   joinColumns={
     *     @ORM\JoinColumn(name="commitment", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_inf", referencedColumnName="limit_inf"),
     *     @ORM\JoinColumn(name="category_sup", referencedColumnName="limit_sup")
     *   }
     * )
     */
    private $categoryInf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activityType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categoryInf = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set icon
     *
     * @param string $icon
     *
     * @return Commitment
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Commitment
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
     * Add activityType
     *
     * @param \AppBundle\Entity\ActivityType $activityType
     *
     * @return Commitment
     */
    public function addActivityType(\AppBundle\Entity\ActivityType $activityType)
    {
        $this->activityType[] = $activityType;

        return $this;
    }

    /**
     * Remove activityType
     *
     * @param \AppBundle\Entity\ActivityType $activityType
     */
    public function removeActivityType(\AppBundle\Entity\ActivityType $activityType)
    {
        $this->activityType->removeElement($activityType);
    }

    /**
     * Get activityType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * Add categoryInf
     *
     * @param \AppBundle\Entity\Category $categoryInf
     *
     * @return Commitment
     */
    public function addCategoryInf(\AppBundle\Entity\Category $categoryInf)
    {
        $this->categoryInf[] = $categoryInf;

        return $this;
    }

    /**
     * Remove categoryInf
     *
     * @param \AppBundle\Entity\Category $categoryInf
     */
    public function removeCategoryInf(\AppBundle\Entity\Category $categoryInf)
    {
        $this->categoryInf->removeElement($categoryInf);
    }

    /**
     * Get categoryInf
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryInf()
    {
        return $this->categoryInf;
    }
}
