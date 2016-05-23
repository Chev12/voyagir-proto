<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="is_owner", type="integer")
     */
    private $isOwner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Establishment", mappedBy="userCreator")
     */
    private $establishments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Establishment", mappedBy="userOwner")
     */
    private $establishmentsOwned;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->establishments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->establishmentsOwned = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set validated
     *
     * @param boolean $isOwner
     *
     * @return BaseUser
     */
    public function setOwner($isOwner)
    {
        $this->isOwner = $isOwner?1:0;
        return $this;
    }

    /**
     * Is this user a owner
     *
     * @return boolean
     */
    public function isOwner()
    {
        return $this->isOwner===1;
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

    /**
     * Add establishment owned
     *
     * @param \AppBundle\Entity\Establishment $establishment
     *
     * @return BaseUser
     */
    public function addEstablishmentOwned(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishmentsOwned[] = $establishment;

        return $this;
    }

    /**
     * Remove establishment owned
     *
     * @param \AppBundle\Entity\Establishment $establishment
     */
    public function removeEstablishmentOwned(\AppBundle\Entity\Establishment $establishment)
    {
        $this->establishmentsOwned->removeElement($establishment);
    }

    /**
     * Get establishments owned
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstablishmentsOwned()
    {
        return $this->establishmentsOwned;
    }
}
