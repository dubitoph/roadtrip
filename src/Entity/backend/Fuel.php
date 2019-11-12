<?php

namespace App\Entity\backend;

use Cocur\Slugify\Slugify;
use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\FuelRepository")
 * @UniqueEntity(
 *     fields={"fuel"},
 *     message="The encoded fuel already exists."
 * )
 */
class Fuel
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
     *      message = "The fuel can't be empty."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "The fuel must at least contain {{limit}} characters.",
     *      maxMessage = "Fuel can't exceed {{limit}} characters."
     * )
     */
    private $fuel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="fuel")
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
     * Get the fuel
     *
     * @return string|null
     */
    public function getFuel(): ?string
    {

        return $this->fuel;

    }

    /**
     * Set the fuel
     *
     * @param string $fuel
     * 
     * @return self
     */
    public function setFuel(string $fuel): self
    {

        $this->fuel = $fuel;

        return $this;

    }

    /**
     * Get the vehicles with this fuel type
     *
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    /**
     * Add a vehicle with this fuel type
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
            $vehicle->setFuel($this);

        }

        return $this;

    }

    /**
     * Remove a vehicle with this fuel type
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
            if ($vehicle->getFuel() === $this) 
            {

                $vehicle->setFuel(null);

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

        return $slugify = (new Slugify())->slugify($this->fuel);

    }
}
