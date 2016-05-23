<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Establishment
 *
 * @ORM\Table(name="establishment", indexes={@ORM\Index(name="id_user", columns={"user_owner"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Establishment
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="useful_info", type="text", length=65535, nullable=true)
     */
    private $usefulInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_commitments", type="text", length=65535, nullable=true)
     */
    private $customCommitments;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=200, nullable=false)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_city", type="string", length=255, nullable=true)
     */
    private $adressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_region", type="string", length=255, nullable=true)
     */
    private $adressRegion;

    /**
     * @var \AppBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adress_country", referencedColumnName="id")
     * })
     */
    private $adressCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_mail", type="string", length=255, nullable=true)
     */
    private $contactMail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_fb", type="string", length=255, nullable=true)
     */
    private $contactFb;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_twt", type="string", length=255, nullable=true)
     */
    private $contactTwt;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_website", type="string", length=255, nullable=true)
     */
    private $contactWebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=255, nullable=true)
     */
    private $contactPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="coord", type="string", length=255, nullable=true)
     */
    private $coord;
    
    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \BaseUser
     *
     * @ORM\ManyToOne(targetEntity="BaseUser", inversedBy="establishmentsOwned")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_owner", referencedColumnName="id")
     * })
     */
    private $userOwner;

    /**
     * @var \BaseUser
     *
     * @ORM\ManyToOne(targetEntity="BaseUser", inversedBy="establishments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_creator", referencedColumnName="id")
     * })
     */
    private $userCreator;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="validated", type="integer", options={"default" = 0})
     */
    private $validated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validated_at", type="datetime", nullable=true)
     */
    private $validatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_at", type="datetime", nullable=true)
     */
    private $lastUpdateAt;

    /**
     * @ORM\Column(name="image_name", type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Label", inversedBy="establishments")
     * @ORM\JoinTable(name="establishment_label",
     *   joinColumns={
     *     @ORM\JoinColumn(name="establishment", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="label", referencedColumnName="id")
     *   }
     * )
     */
    private $labels;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EstablishmentActivity", mappedBy="establishment", cascade={"remove"})
     */
    private $activities;

    /**
     * @ORM\Column(name="image_offset", type="integer", length=4)
     *
     * @var string
     */
    private $imageOffset;
    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="establishment_image", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->labels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Return the name of the image, combination of the id and the name
     * of the establishment
     * @return type
     */
    public function getImageNameById() {
        return $this->id.'_'.$this->name;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File $image
     *
     * @return Establishment
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->lastUpdateAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
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
     * Set name
     *
     * @param string $name
     *
     * @return Establishment
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
     * @return Establishment
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
     * Set adress
     *
     * @param string $adress
     *
     * @return Establishment
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Establishment
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set userOwner
     *
     * @param \AppBundle\Entity\BaseUser $userOwner
     *
     * @return Establishment
     */
    public function setUserOwner(\AppBundle\Entity\BaseUser $userOwner = null)
    {
        $this->userOwner = $userOwner;

        return $this;
    }

    /**
     * Get userOwner
     *
     * @return \AppBundle\Entity\BaseUser
     */
    public function getUserOwner()
    {
        return $this->userOwner;
    }

    /**
     * Set userCreator
     *
     * @param \AppBundle\Entity\BaseUser $userCreator
     *
     * @return Establishment
     */
    public function setUserCreator(\AppBundle\Entity\BaseUser $userCreator = null)
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    /**
     * Get userCreator
     *
     * @return \AppBundle\Entity\BaseUser
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }

    /**
     * Add label
     *
     * @param \AppBundle\Entity\Label $label
     *
     * @return Establishment
     */
    public function addLabel(\AppBundle\Entity\Label $label)
    {
        $this->labels[] = $label;

        return $this;
    }

    /**
     * Remove label
     *
     * @param \AppBundle\Entity\Label $label
     */
    public function removeLabel(\AppBundle\Entity\Label $label)
    {
        $this->labels->removeElement($label);
    }

    /**
     * Get labels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Add activity
     *
     * @param \AppBundle\Entity\EstablishmentActivity $activity
     *
     * @return Establishment
     */
    public function addActivity(\AppBundle\Entity\EstablishmentActivity $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AppBundle\Entity\EstablishmentActivity $activity
     */
    public function removeActivity(\AppBundle\Entity\EstablishmentActivity $activity)
    {
        $this->activities->removeElement($activity);
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
     * Set usefulInfo
     *
     * @param string $usefulInfo
     *
     * @return Establishment
     */
    public function setUsefulInfo($usefulInfo)
    {
        $this->usefulInfo = $usefulInfo;

        return $this;
    }

    /**
     * Get usefulInfo
     *
     * @return string
     */
    public function getUsefulInfo()
    {
        return $this->usefulInfo;
    }

    /**
     * Set customCommitments
     *
     * @param string $customCommitments
     *
     * @return Establishment
     */
    public function setCustomCommitments($customCommitments)
    {
        $this->customCommitments = $customCommitments;

        return $this;
    }

    /**
     * Get customCommitments
     *
     * @return string
     */
    public function getCustomCommitments()
    {
        return $this->customCommitments;
    }

    /**
     * Set adressCity
     *
     * @param string $adressCity
     *
     * @return Establishment
     */
    public function setAdressCity($adressCity)
    {
        $this->adressCity = $adressCity;

        return $this;
    }

    /**
     * Get adressCity
     *
     * @return string
     */
    public function getAdressCity()
    {
        return $this->adressCity;
    }

    /**
     * Set adressRegion
     *
     * @param string $adressRegion
     *
     * @return Establishment
     */
    public function setAdressRegion($adressRegion)
    {
        $this->adressRegion = $adressRegion;

        return $this;
    }

    /**
     * Get adressRegion
     *
     * @return string
     */
    public function getAdressRegion()
    {
        return $this->adressRegion;
    }

    /**
     * Set contactMail
     *
     * @param string $contactMail
     *
     * @return Establishment
     */
    public function setContactMail($contactMail)
    {
        $this->contactMail = $contactMail;

        return $this;
    }

    /**
     * Get contactMail
     *
     * @return string
     */
    public function getContactMail()
    {
        return $this->contactMail;
    }

    /**
     * Set contactFb
     *
     * @param string $contactFb
     *
     * @return Establishment
     */
    public function setContactFb($contactFb)
    {
        $this->contactFb = $contactFb;

        return $this;
    }

    /**
     * Get contactFb
     *
     * @return string
     */
    public function getContactFb()
    {
        return $this->contactFb;
    }

    /**
     * Set contactTwt
     *
     * @param string $contactTwt
     *
     * @return Establishment
     */
    public function setContactTwt($contactTwt)
    {
        $this->contactTwt = $contactTwt;

        return $this;
    }

    /**
     * Get contactTwt
     *
     * @return string
     */
    public function getContactTwt()
    {
        return $this->contactTwt;
    }

    /**
     * Set contactWebsite
     *
     * @param string $contactWebsite
     *
     * @return Establishment
     */
    public function setContactWebsite($contactWebsite)
    {
        $this->contactWebsite = $contactWebsite;

        return $this;
    }

    /**
     * Get contactWebsite
     *
     * @return string
     */
    public function getContactWebsite()
    {
        return $this->contactWebsite;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     *
     * @return Establishment
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Set coord
     *
     * @param string $coord
     *
     * @return Establishment
     */
    public function setCoord($coord)
    {
        $this->coord = $coord;

        return $this;
    }

    /**
     * Get coord
     *
     * @return string
     */
    public function getCoord()
    {
        return $this->coord;
    }

    /**
     * Set adressCountry
     *
     * @param \AppBundle\Entity\Country $adressCountry
     *
     * @return Establishment
     */
    public function setAdressCountry(\AppBundle\Entity\Country $adressCountry = null)
    {
        $this->adressCountry = $adressCountry;

        return $this;
    }

    /**
     * Get adressCountry
     *
     * @return \AppBundle\Entity\Country
     */
    public function getAdressCountry()
    {
        return $this->adressCountry;
    }

    /**
     * @param string $imageName
     *
     * @return Establishment
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param integer $imageOffset
     *
     * @return Establishment
     */
    public function setImageOffset($imageOffset)
    {
        $this->imageOffset = $imageOffset;

        return $this;
    }

    /**
     * @return integer
     */
    public function getImageOffset()
    {
        return $this->imageOffset;
    }

    /**
     * Set validated
     *
     * @param integer $validated
     *
     * @return Establishment
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return integer
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $validatedAt
     *
     * @return Establishment
     */
    public function setValidatedAt($validatedAt)
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getValidatedAt()
    {
        return $this->validatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Establishment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lastUpdateAt
     *
     * @param \DateTime $lastUpdateAt
     *
     * @return Establishment
     */
    public function setLastUpdateAt($lastUpdateAt)
    {
        $this->lastUpdateAt = $lastUpdateAt;

        return $this;
    }

    /**
     * Get lastUpdateAt
     *
     * @return \DateTime
     */
    public function getLastUpdateAt()
    {
        return $this->lastUpdateAt;
    }
}
