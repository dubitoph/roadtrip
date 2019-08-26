<?php

namespace App\Entity\backend;

use Cocur\Slugify\Slugify;
use App\Entity\advert\Price;
use App\Entity\advert\Period;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\SeasonRepository")
 * 
 * @UniqueEntity(
 *     fields={"season"},
 *     message="La saison encodée existe déjà"
 * )
 * @UniqueEntity(
 *     fields={"cost"},
 *     message="TThe encoded cost position is already used."
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
     * @ORM\Column(type="string", length=20, unique=true)
     *      
     * @Assert\NotBlank(
     *      message = "La marque ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The season must be contain at least {{ limit }} characters",
     *      maxMessage = "The season can't be contain more than {{ limit }} characters"
     * )
     */
    private $season;

    /**
     * @ORM\Column(type="integer", unique=true)
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 1,
     *     message = "The cost position must be greater or equal than {{ value }}."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 20,
     *     message = "The cost position must be less or equal than {{ value }}."
     * )
     * @Assert\NotBlank(
     *      message = "The cost position can't be empty."
     * )
     */
    private $cost;

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

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->season);

    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
