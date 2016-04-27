<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentEstablishment
 *
 * @ORM\Table(name="comment_establishment", indexes={@ORM\Index(name="fk_com_etb_user", columns={"user"}), @ORM\Index(name="establishment", columns={"establishment"})})
 * @ORM\Entity
 */
class CommentEstablishment
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
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

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
     * @var \BaseUser
     *
     * @ORM\ManyToOne(targetEntity="BaseUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set comment
     *
     * @param string $comment
     *
     * @return CommentEstablishment
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
     * Set note
     *
     * @param integer $note
     *
     * @return CommentEstablishment
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return CommentEstablishment
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\BaseUser $user
     *
     * @return CommentEstablishment
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
}
