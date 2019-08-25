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
     * @Assert\GreaterThanOrEqual(
     *     value = 500,
     *     message = "The milage must be greather or equal than {value} km."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 10000,
     *     message = "The milage must be less or equal than {value} km."
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

    /**
     * Get the id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get the milage
     *
     * @return integer|null
     */
    public function getMileage(): ?int
    {

        return $this->mileage;

    }

    /**
     * Set the milage
     *
     * @param integer $mileage
     * @return self
     */
    public function setMileage(int $mileage): self
    {

        $this->mileage = $mileage;

        return $this;

    }

    /**
     * Get the advert
     *
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {

        return $this->advert;

    }

    /**
     * Set the advert
     *
     * @param Advert|null $advert
     * @return self
     */
    public function setAdvert(?Advert $advert): self
    {

        $this->advert = $advert;

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
    
}
