<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category", uniqueConstraints={@ORM\UniqueConstraint(name="limits", columns={"limit_inf", "limit_sup"} )})
 * @ORM\Entity
 */
class Category
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
     * @var integer
     *
     * @ORM\Column(name="limit_inf", type="integer", nullable=false)
     */
    private $limitInf;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_sup", type="integer", nullable=false)
     */
    private $limitSup;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commitment", inversedBy="categories")
     * @ORM\JoinTable(name="category_commitment",
     *   joinColumns={
     *     @ORM\JoinColumn(name="category", referencedColumnName="id")
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
        $this->commitment = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set limitInf
     *
     * @param integer $limitInf
     *
     * @return Category
     */
    public function setLimitInf($limitInf)
    {
        $this->limitInf = $limitInf;

        return $this;
    }

    /**
     * Get limitInf
     *
     * @return integer
     */
    public function getLimitInf()
    {
        return $this->limitInf;
    }

    /**
     * Set limitSup
     *
     * @param integer $limitSup
     *
     * @return Category
     */
    public function setLimitSup($limitSup)
    {
        $this->limitSup = $limitSup;

        return $this;
    }

    /**
     * Get limitSup
     *
     * @return integer
     */
    public function getLimitSup()
    {
        return $this->limitSup;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Category
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * @return Category
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
     * Add commitment
     *
     * @param \AppBundle\Entity\Commitment $commitment
     *
     * @return Category
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
     * Get commitments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommitments()
    {
        return $this->commitments;
    }
}
