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
     * @Assert\LessThan(
     *     value = 3000,
     *     message = "La longeur doit être inférieure à 3000€."
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(?Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getInsurance(): ?Insurance
    {
        return $this->insurance;
    }

    public function setInsurance(?Insurance $insurance): self
    {
        $this->insurance = $insurance;

        return $this;
    }
}
