<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAnswer
 *
 * @ORM\Table(name="user_answer", indexes={@ORM\Index(name="establishment", columns={"establishment"}), @ORM\Index(name="user", columns={"user"}), @ORM\Index(name="question", columns={"question"})})
 * @ORM\Entity
 */
class UserAnswer
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
     * @ORM\Column(name="answer", type="text", length=255, nullable=false)
     */
    private $answer;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var \CommitmentQuestion
     *
     * @ORM\ManyToOne(targetEntity="CommitmentQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @var \BaseUser
     *
     * @ORM\ManyToOne(targetEntity="BaseUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Establishment
     *
     * @ORM\ManyToOne(targetEntity="Establishment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="establishment", referencedColumnName="id")
     * })
     */
    private $establishment;



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
     * Set answer
     *
     * @param string $answer
     *
     * @return UserAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return UserAnswer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\CommitmentQuestion $question
     *
     * @return UserAnswer
     */
    public function setQuestion(\AppBundle\Entity\CommitmentQuestion $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\CommitmentQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\BaseUser $user
     *
     * @return UserAnswer
     */
    public function setUser(\AppBundle\Entity\BaseUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\BaseUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return UserAnswer
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
}
