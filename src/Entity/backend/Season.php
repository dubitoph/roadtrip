<?php

namespace App\Entity\backend;

use Cocur\Slugify\Slugify;
use App\Entity\advert\Price;
use App\Entity\advert\Period;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\SeasonRepository")
 * 
 * @UniqueEntity(
 *     fields={"season"},
 *     message="La saison encodée existe déjà"
 * )
 */
class Season
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     *      
     * @Assert\NotBlank(
     *      message = "La marque ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "La saison doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La saison ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $season;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Period", mappedBy="season")
     */
    private $periods;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Price", mappedBy="season")
     */
    private $prices;

    public function __construct()
    {
        $this->periods = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }

    public function __toString(){
        return $this->season;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): self
    {
        $this->season = $season;

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
            $period->setSeason($this);
        }

        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period)) {
            $this->periods->removeElement($period);
            // set the owning side to null (unless already changed)
            if ($period->getSeason() === $this) {
                $period->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setSeason($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getSeason() === $this) {
                $price->setSeason(null);
            }
        }

        return $this;
    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->season);

    }
}
