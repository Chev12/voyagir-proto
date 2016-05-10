<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country", uniqueConstraints={@ORM\UniqueConstraint(name="alpha2", columns={"alpha2"}), @ORM\UniqueConstraint(name="alpha3", columns={"alpha3"}), @ORM\UniqueConstraint(name="code_unique", columns={"code"})})
 * @ORM\Entity
 */
class Country
{
    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha2", type="string", length=2, nullable=false)
     */
    private $alpha2;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha3", type="string", length=3, nullable=false)
     */
    private $alpha3;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en_gb", type="string", length=45, nullable=false)
     */
    private $nameEnGb;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr_fr", type="string", length=45, nullable=false)
     */
    private $nameFrFr;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    
    
    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set alpha2
     *
     * @param string $alpha2
     *
     * @return Country
     */
    public function setAlpha2($alpha2)
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * Get alpha2
     *
     * @return string
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * Set alpha3
     *
     * @param string $alpha3
     *
     * @return Country
     */
    public function setAlpha3($alpha3)
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    /**
     * Get alpha3
     *
     * @return string
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }

    /**
     * Set nameEnGb
     *
     * @param string $nameEnGb
     *
     * @return Country
     */
    public function setNameEnGb($nameEnGb)
    {
        $this->nameEnGb = $nameEnGb;

        return $this;
    }

    /**
     * Get nameEnGb
     *
     * @return string
     */
    public function getNameEnGb()
    {
        return $this->nameEnGb;
    }

    /**
     * Set nameFrFr
     *
     * @param string $nameFrFr
     *
     * @return Country
     */
    public function setNameFrFr($nameFrFr)
    {
        $this->nameFrFr = $nameFrFr;

        return $this;
    }

    /**
     * Get nameFrFr
     *
     * @return string
     */
    public function getNameFrFr()
    {
        return $this->nameFrFr;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
