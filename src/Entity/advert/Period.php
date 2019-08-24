<?php

namespace App\Entity\advert;

use App\Entity\advert\Price;
use App\Entity\advert\Advert;
use App\Entity\backend\Season;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\PeriodRepository")
 * 
 * @UniqueEntity(
 *     fields={"start", "end", "advert"},
 *     message="A period concerning this advert already exists for this start and end dates."
 * )
 */
class Period
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime()
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\DateTime()
     * @Assert\GreaterThan(
     *      propertyPath="start",
     *      message="The end date must be later than the start date."
     * )
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Season")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Season")
     * @Assert\Valid()
     */
    private $season;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\advert\Price", mappedBy="periods")
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="periods")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->prices = new ArrayCollection();

    }

    /**
     * Get id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get the beginning date
     *
     * @return \DateTimeInterface|null
     */
    public function getStart(): ?\DateTimeInterface
    {

        return $this->start;

    }

    /**
     * Set the beginning date
     *
     * @param \DateTimeInterface $start
     * @return self
     */
    public function setStart(\DateTimeInterface $start): self
    {

        $this->start = $start;

        return $this;

    }

    /**
     * Get the end date
     *
     * @return \DateTimeInterface|null
     */
    public function getEnd(): ?\DateTimeInterface
    {

        return $this->end;

    }

    /**
     * Set the end date
     *
     * @param \DateTimeInterface $end
     * @return self
     */
    public function setEnd(\DateTimeInterface $end): self
    {

        $this->end = $end;

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

    /**
     * Get the prices|Price[]
     *
     * @return Collection
     */
     public function getPrices(): Collection
    {

        return $this->prices;

    }

    /**
     * Add a price
     *
     * @param Price $price
     * @return self
     */
    public function addPrice(Price $price): self
    {

        if (!$this->prices->contains($price)) 
        {

            $this->prices[] = $price;
            $price->addPeriod($this);

        }

        return $this;

    }

    /**
     * Remove a price
     *
     * @param Price $price
     * @return self
     */
    public function removePrice(Price $price): self
    {

        if ($this->prices->contains($price)) 
        {

            $this->prices->removeElement($price);
            $price->removePeriod($this);

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

}
