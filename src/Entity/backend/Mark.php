<?php

namespace App\Entity\backend;

use Cocur\Slugify\Slugify;
use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\MarkRepository")
 * 
 * @UniqueEntity(
 *     fields={"mark"},
 *     message="The encoded mark already exists."
 * )
 */
class Mark
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(
     *      message = "La marque ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "The mark must at least contain {{limit}} characters.",
     *      maxMessage = "Mark can't exceed {{characters}}."
     * )
     */
    private $mark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="mark")
     */
    private $vehicles;

    /**
     * The constructor
     */
    public function __construct()
    {

        $this->vehicles = new ArrayCollection();

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
     * Get the mark
     *
     * @return string|null
     */
    public function getMark(): ?string
    {

        return $this->mark;

    }

    /**
     * Set the mark
     *
     * @param string $mark
     * 
     * @return self
     */
    public function setMark(string $mark): self
    {

        $this->mark = $mark;

        return $this;

    }

    /**
     * Get vehicles with this mark
     *
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {

        return $this->vehicles;

    }

    /**
     * Add a vehicle with this mark
     *
     * @param Vehicle $vehicle
     * 
     * @return self
     */
    public function addVehicle(Vehicle $vehicle): self
    {

        if (!$this->vehicles->contains($vehicle)) 
        {

            $this->vehicles[] = $vehicle;
            $vehicle->setMark($this);

        }

        return $this;

    }

    /**
     * Remove a vehicle with this mark
     *
     * @param Vehicle $vehicle
     * 
     * @return self
     */
    public function removeVehicle(Vehicle $vehicle): self
    {

        if ($this->vehicles->contains($vehicle)) 
        {

            $this->vehicles->removeElement($vehicle);

            // set the owning side to null (unless already changed)
            if ($vehicle->getMark() === $this) 
            {

                $vehicle->setMark(null);

            }

        }

        return $this;
        
    }

    /**
     * Get the slug
     *
     * @return string
     */
    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->mark);

    }
}
