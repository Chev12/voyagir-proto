<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\Category;
use AppBundle\Entity\CommitmentQuestion;

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
     * @var \Doctrine\Common\Collections\ArrayCollection 
     * 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ActivityType", mappedBy="commitments")
     */
    private $activities;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection 
     * 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", mappedBy="commitments")
     */
    private $categories;
    
    /**
     * Original questions, needed in the case of removing questions.
     * Not persisted
     * @var \Doctrine\Common\Collections\Collection
     */
    private $originalQuestions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->originalQuestions = new ArrayCollection();
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
     * Set original questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function addOriginalQuestions($question)
    {
        $this->originalQuestions[] = $question;
        return $this;
    }

    
    /**
     * Add question
     *
     * @param \AppBundle\Entity\CommitmentQuestion $question
     *
     * @return BaseUser
     */
    public function addQuestion(CommitmentQuestion $question)
    {
        $this->questions[] = $question;
        $question->setCommitment($this);
        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\CommitmentQuestion $question
     */
    public function removeQuestion(CommitmentQuestion $question)
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
     * Add activity
     *
     * @param \AppBundle\Entity\ActivityType $activity
     *
     * @return BaseUser
     */
    public function addActivity(ActivityType $activity)
    {
        $this->activities[] = $activity;
        $activity->setCommitment($this);
        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AppBundle\Entity\ActivityType $activities
     */
    public function removeActivity(ActivityType $activities)
    {
        $this->activities->removeElement($activities);
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
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return BaseUser
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        $category->setCommitment($this);
        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $categories
     */
    public function removeCategory(Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
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
