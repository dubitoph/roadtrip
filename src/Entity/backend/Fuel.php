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
 *     message="Le carburant encodé existe déjà"
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
     *      message = "Le carburant ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le carburant doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "Le carburant ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $fuel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="fuel")
     */
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setFuel($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getFuel() === $this) {
                $vehicle->setFuel(null);
            }
        }

        return $this;
    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->fuel);

    }
}
