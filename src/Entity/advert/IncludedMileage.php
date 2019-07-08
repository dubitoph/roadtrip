<?php

namespace App\Entity\advert;

use App\Entity\advert\Advert;
use App\Entity\backend\Duration;
use Doctrine\ORM\Mapping as ORM;;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\IncludedMileageRepository")
 */
class IncludedMileage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\GreaterThan(
     *     value = 500,
     *     message = "Le kilométarge inclus doit être supérieur à 500 km."
     * )
     * @Assert\LessThan(
     *     value = 10000,
     *     message = "Le kilométarge inclus ne peut être supérieur à 10000 km."
     * )
     */
    private $mileage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="includedMileages")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Duration")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Duration")
     * @Assert\Valid()
     */
    private $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

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
}
