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
 *     message="Cet équipement existe déjà pour cette appartenance."
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
     *      message = "L'équipement ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "L'équipement doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "L'équipement ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $equipment;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank(
     *      message = "L'appartenance ne peut pas être vide."
     * )
     * @Assert\Choice({"Porteur", "Cellule"})
     */
    private $belonging;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="equipments")
     */
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function __toString(){
        return $this->equipment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(string $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getBelonging(): ?string
    {
        return $this->belonging;
    }

    public function setBelonging(string $belonging): self
    {
        $this->belonging = $belonging;

        return $this;
    }

    /**
     * Get vehicles
     *
     * @return Collection
     */
    public function getVehicles(): Collection
    {

        return $this->vehicles;

    }

    /**
     * Set vehicles
     *
     * @param ArrayCollection $vehicles
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
