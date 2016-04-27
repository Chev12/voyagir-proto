<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentActivity
 *
 * @ORM\Table(name="comment_activity", indexes={@ORM\Index(name="establishment_activity", columns={"activity"}), @ORM\Index(name="user", columns={"user"})})
 * @ORM\Entity
 */
class CommentActivity
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
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var \EstablishmentActivity
     *
     * @ORM\ManyToOne(targetEntity="EstablishmentActivity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity", referencedColumnName="id")
     * })
     */
    private $activity;



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
     * Set user
     *
     * @param integer $user
     *
     * @return CommentActivity
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return CommentActivity
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
     * Set activity
     *
     * @param \AppBundle\Entity\EstablishmentActivity $activity
     *
     * @return CommentActivity
     */
    public function setActivity(\AppBundle\Entity\EstablishmentActivity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\EstablishmentActivity
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
