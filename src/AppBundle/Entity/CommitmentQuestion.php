<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommitmentQuestion
 *
 * @ORM\Table(name="commitment_question", uniqueConstraints={@ORM\UniqueConstraint(name="commitment_order", columns={"commitment", "order"})}, indexes={@ORM\Index(name="commitment", columns={"commitment"})})
 * @ORM\Entity
 */
class CommitmentQuestion
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
     * @ORM\Column(name="question", type="text", length=65535, nullable=false)
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var \Commitment
     *
     * @ORM\ManyToOne(targetEntity="Commitment", inversedBy="questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commitment", referencedColumnName="id")
     * })
     */
    private $commitment;


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
     * Set question
     *
     * @param string $question
     *
     * @return CommitmentQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return CommitmentQuestion
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return CommitmentQuestion
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
     * Set commitment
     *
     * @param \AppBundle\Entity\Commitment $commitment
     *
     * @return Commitment
     */
    public function setCommitment(\AppBundle\Entity\Commitment $commitment = null)
    {
        $this->commitment = $commitment;

        return $this;
    }

    /**
     * Get commitment
     *
     * @return \AppBundle\Entity\Commitment
     */
    public function getCommitment()
    {
        return $this->commitment;
    }
}
