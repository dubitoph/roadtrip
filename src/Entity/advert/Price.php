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
 *     message="A price already exists for this season and this duration."
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
     * @Assert\GreaterThanOrEqual(
     *     value = 100,
     *     message = "The price must be greater than {{value}} €."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 3000,
     *     message = "The price must be less than {{value}} €."
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
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Season")
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

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->periods = new ArrayCollection();

    }

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
     * Get the price
     *
     * @return integer|null
     */
    public function getPrice(): ?int
    {

        return $this->price;

    }

    /**
     * Get the formatted price
     *
     * @return string
     */
    public function getFormattedPrice(): string
    {

        return number_format($this->price, 0, '', ' ');

    }

    /**
     * Set the price
     *
     * @param integer $price
     * @return self
     */
    public function setPrice(int $price): self
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
     * @param Duration $duration
     * @return self
     */
    public function setDuration(Duration $duration): self
    {

        $this->duration = $duration;

        return $this;

    }

    /**
     * Get periods
     *
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {

        return $this->periods;

    }

    /**
     * Add a period
     *
     * @param Period $period
     * @return self
     */
    public function addPeriod(Period $period): self
    {

        if (!$this->periods->contains($period)) 
        {

            $this->periods[] = $period;

        }

        return $this;

    }

    /**
     * Remove a period
     *
     * @param Period $period
     * @return self
     */
    public function removePeriod(Period $period): self
    {

        if ($this->periods->contains($period)) 
        {

            $this->periods->removeElement($period);

        }

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
     * Get the season
     *
     * @return Season|null
     */
    public function getSeason(): ?Season
    {

        return $this->season;

    }

    /**
     * Set the season
     *
     * @param Season|null $season
     * @return self
     */
    public function setSeason(?Season $season): self
    {

        $this->season = $season;

        return $this;

    }

}
