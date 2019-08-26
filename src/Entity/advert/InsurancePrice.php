<?php

namespace App\Entity\advert;

use App\Entity\advert\Insurance;
use App\Entity\backend\Duration;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\InsurancePriceRepository")
 */
class InsurancePrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", scale=2, precision=6)
     *  
     * @Assert\GreaterThanOrEqual(
     *     value = 5,
     *     message = "The price must be greater or equal than the {value}€."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 3000,
     *     message = "The price must be less or equal than the {value}€."
     * )
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Duration")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Duration")
     * @Assert\Valid()
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Insurance", inversedBy="insurancePrices")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\advert\Insurance")
     * @Assert\Valid()
     */
    private $insurance;

    /**
     * Set the id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the price
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {

        return $this->price;

    }

    /**
     * Set the price
     *
     * @param float $price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the duration
     *
     * @return Duration|null
     */
    public function getDuration(): ?Duration
    {

        return $this->duration;

    }

    /**
     * Set the duration
     *
     * @param Duration|null $duration
     * @return self
     */
    public function setDuration(?Duration $duration): self
    {

        $this->duration = $duration;

        return $this;

    }

    /**
     * Get the insurance
     *
     * @return Insurance|null
     */
    public function getInsurance(): ?Insurance
    {

        return $this->insurance;

    }

    /**
     * Set the insurance
     *
     * @param Insurance|null $insurance
     * @return self
     */
    public function setInsurance(?Insurance $insurance): self
    {

        $this->insurance = $insurance;

        return $this;

    }
}
