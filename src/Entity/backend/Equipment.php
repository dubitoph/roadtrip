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
 * @ORM\Entity(repositoryClass="App\Repository\backend\EquipmentRepository")
 * 
 * @UniqueEntity(
 *     fields={"equipment", "belonging"},
 *     message="This equipment already exists for this belonging."
 * )
 */
class Equipment
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
     *      message = "The equipment can't be empty."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "The equipment must at least contain {{limit}} characters.",
     *      maxMessage = "The equipment can not exceed {{limit}} characters."
     * )
     */
    private $equipment;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank(
     *      message = "The belonging can't be empty."
     * )
     * @Assert\Choice({"Carrier", "Cell"})
     */
    private $belonging;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="equipments")
     */
    private $vehicles;

    /**
     * Constructor
     */
    public function __construct()
    {

        $this->vehicles = new ArrayCollection();

    }

    /**
     * Get a string representing the equipment
     *
     * @return string
     */
    public function __toString()
    {

        return $this->equipment;

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
     * Get the equipment
     *
     * @return string|null
     */
    public function getEquipment(): ?string
    {

        return $this->equipment;

    }

    /**
     * Set the equipment
     *
     * @param string $equipment
     * 
     * @return self
     */
    public function setEquipment(string $equipment): self
    {

        $this->equipment = $equipment;

        return $this;

    }

    /**
     * Get the belonging
     *
     * @return string|null
     */
    public function getBelonging(): ?string
    {

        return $this->belonging;

    }

    /**
     * Set the belonging
     *
     * @param string $belonging
     * 
     * @return self
     */
    public function setBelonging(string $belonging): self
    {

        $this->belonging = $belonging;

        return $this;

    }

    /**
     * Get vehicles
     *
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {

        return $this->vehicles;

    }

    /**
     * Set vehicles
     *
     * @param ArrayCollection $vehicles
     * 
     * @return void
     */
    public function setVehicles(ArrayCollection $vehicles)
    {

        $this->vehicles = $vehicles;

    }

    /**
     * Add vehicle
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

        }

        return $this;

    }

    /**
     * Remove vehicle
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

        }

        return $this;

    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->equipment . '-' . $this->belonging->getBelonging());

    }

}
