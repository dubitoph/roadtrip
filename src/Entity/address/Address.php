<?php

namespace App\Entity\address;

use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\address\AddressRepository")
 * 
 * @UniqueEntity(
 *               fields={"street", "number", "box", "zipCode", "country"},
 *               message="Cette adresse existe déjà. Veuillez donc la sélectionner et non la créer."
 * )
 */
class Address
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
     *      message = "La sorte ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "La rue doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La rue ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=6)
     * 
     * @Assert\NotBlank(
     *      message = "Le numéro ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 6,
     *      minMessage = "Le numéro doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "Le numéro ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "La boîte doit être supérieure à 0."
     * )
     * @Assert\LessThan(
     *     value = 1000,
     *     message = "La boîte doit être supérieure à 1000."
     * )
     */
    private $box;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank(
     *      message = "Le code postal ne peut pas être vide."
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\NotBlank(
     *      message = "La ville ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "La ville doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La ville ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "L'état doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "L'état ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     */
    private $country;

    /**
     * @ORM\Column(type="float", scale=4, precision=6)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", scale=4, precision=7)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert\Vehicle", mappedBy="situation")
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBox(): ?int
    {
        return $this->box;
    }

    public function setBox(?int $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }
    
    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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
            $vehicle->setSituation($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getSituation() === $this) {
                $vehicle->setSituation(null);
            }
        }

        return $this;
    }
}
