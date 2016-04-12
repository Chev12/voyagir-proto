<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User;

/**
 * BaseUser
 *
 * @ORM\Table(name="base_user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1BF018B992FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_1BF018B9A0D96FBF", columns={"email_canonical"})})
 * @ORM\Entity
 */
class BaseUser extends User
{
     /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Establishment", mappedBy="userOwner")
     */
    protected $establishments;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->establishments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return BaseUser
     */
    public function addEstablishment(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishments[] = $establishment;

        return $this;
    }

    /**
     * Remove establishment
     *
     * @param \AppBundle\Entity\Establishment $establishment
     */
    public function removeEstablishment(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishments->removeElement($establishment);
    }

    /**
     * Get establishments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstablishments()
    {
        return $this->establishments;
    }
}
