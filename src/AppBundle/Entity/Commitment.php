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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommitmentQuestion", cascade={"persist", "remove"}, mappedBy="commitment")
     */
    private $questions;
    
    
    /**
     * Original questions, needed in the case of removing questions
     * @var \Doctrine\Common\Collections\Collection
     */
    private $originalQuestions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->originalQuestions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get original questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOriginalQuestions()
    {
        return $this->originalQuestions;
    }

    /**
     * Set original uestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function addOriginalQuestions($question)
    {
        $this->originalQuestions[] = $question;
        return $this;
    }

    
    /**
     * Add establishment
     *
     * @param \AppBundle\Entity\CommitmentQuestion $question
     *
     * @return BaseUser
     */
    public function addQuestion(\AppBundle\Entity\CommitmentQuestion $question)
    {
        $this->questions[] = $question;
        $question->setCommitment($this);
        return $this;
    }

    /**
     * Remove establishment
     *
     * @param \AppBundle\Entity\CommitmentQuestion $question
     */
    public function removeQuestion(\AppBundle\Entity\CommitmentQuestion $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
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
}
