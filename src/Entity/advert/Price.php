<?php

namespace App\Entity\advert;

use App\Entity\advert\Advert;
use App\Entity\advert\Period;
use App\Entity\backend\Season;
use App\Entity\backend\Duration;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\PriceRepository")
 * 
 * @UniqueEntity(
 *     fields={"duration", "season"},
 *     message="Un prix existe déjà pour cette saison et cette durée."
 * )
 */
class Price
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
     *     value = 100,
     *     message = "Le prix doit être supérieure à 100 euros."
     * )
     * @Assert\LessThan(
     *     value = 3000,
     *     message = "Le prix doit être inférieure à 3000 euros."
     * )
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\advert\Period", inversedBy="prices")
     */
    private $periods;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Season", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Season")
     * @Assert\Valid()
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Duration")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Duration")
     * @Assert\Valid()
     */
    private $duration;

    public function __construct()
    {
        $this->periods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period)) {
            $this->periods[] = $period;
        }

        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period)) {
            $this->periods->removeElement($period);
        }

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

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }
}
