<?php

namespace App\Entity\address;

use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\address\AddressRepository")
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
     *      message = "The street can't be empty."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "The street must contain at least {{ limit }} characters.",
     *      maxMessage = "The street can't contain more than {{ limit }} characters."
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
     *      minMessage = "The number must contain at least {{ limit }} characters.",
     *      maxMessage = "The number can't contain more than {{ limit }} characters."
     * )
     */
    private $number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "The box must be greater than {value}."
     * )
     * @Assert\LessThan(
     *     value = 1000,
     *     message = "The box must be less than {value}."
     * )
     */
    private $box;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank(
     *      message = "The zipcode can't be empty."
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\NotBlank(
     *      message = "The country can't be empty."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "The city must contain at least {{ limit }} characters.",
     *      maxMessage = "The city can't contain more than {{ limit }} characters."
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "The state must contain at least {{ limit }} characters.",
     *      maxMessage = "The state can't contain more than {{ limit }} characters."
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
     * @ORM\OneToOne(targetEntity="App\Entity\advert\Vehicle", mappedBy="situation")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $defaultUserLocation;

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
     * Get the street
     *
     * @return string|null
     */
    public function getStreet(): ?string
    {

        return $this->street;

    }

    /**
     * Set the street
     *
     * @param string $street
     * @return self
     */
    public function setStreet(string $street): self
    {

        $this->street = $street;

        return $this;

    }

    /**
     * Get the number in the street
     *
     * @return string|null
     */
    public function getNumber(): ?string
    {

        return $this->number;

    }

    /**
     * Set the number in the street
     *
     * @param string $number
     * @return self
     */
    public function setNumber(string $number): self
    {

        $this->number = $number;

        return $this;

    }

    /**
     * Get the box of the number in the street
     *
     * @return integer|null
     */
    public function getBox(): ?int
    {

        return $this->box;

    }

    /**
     * Set the box of the number in the street
     *
     * @param integer|null $box
     * @return self
     */
    public function setBox(?int $box): self
    {

        $this->box = $box;

        return $this;

    }

    /**
     * Get the zipcode
     *
     * @return string|null
     */
    public function getZipCode(): ?string
    {

        return $this->zipCode;

    }

    /**
     * Set the zipcode
     *
     * @param string $zipCode
     * @return self
     */
    public function setZipCode(string $zipCode): self
    {

        $this->zipCode = $zipCode;

        return $this;

    }

    /**
     * Get the city
     *
     * @return string|null
     */
    public function getCity(): ?string
    {

        return $this->city;

    }

    /**
     * Set the city
     *
     * @param string $city
     * @return self
     */
    public function setCity(string $city): self
    {

        $this->city = $city;

        return $this;

    }

    /**
     * Get the state
     *
     * @return string|null
     */
    public function getState(): ?string
    {

        return $this->state;

    }

    /**
     * Set the city
     *
     * @param string|null $state
     * @return self
     */
    public function setState(?string $state): self
    {

        $this->state = $state;

        return $this;

    }
    
    /**
     * Get the country
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {

        return $this->country;

    }

    /**
     * Set the country
     *
     * @param string $country
     * @return self
     */
    public function setCountry(string $country): self
    {

        $this->country = $country;

        return $this;

    }

    /**
     * Get the latitude
     *
     * @return float|null
     */
    public function getLatitude(): ?float
    {

        return $this->latitude;

    }

    /**
     * Set the latitude
     *
     * @param float $latitude
     * @return self
     */
    public function setLatitude(float $latitude): self
    {

        $this->latitude = $latitude;

        return $this;

    }

    /**
     * Get the longitude
     *
     * @return float|null
     */
    public function getLongitude(): ?float
    {

        return $this->longitude;

    }

    /**
     * Set the longitude
     *
     * @param float $longitude
     * @return self
     */
    public function setLongitude(float $longitude): self
    {

        $this->longitude = $longitude;

        return $this;

    }

    /**
     * Get the vehicle
     *
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {

        return $this->vehicle;

    }

    /**
     * Set the vehicle
     *
     * @param Vehicle $vehicle
     * @return self
     */
    public function setVehicle(Vehicle $vehicle): self
    {

        $this->vehicle = $vehicle;

        return $this;

    }

    /**
     * Remove the vehicle
     *
     * @param Vehicle $vehicle
     * @return self
     */
    public function removeVehicle(Vehicle $vehicle): self
    {

        if ($this->vehicles->contains($vehicle)) 
        {

            $this->vehicles->removeElement($vehicle);

            // set the owning side to null (unless already changed)
            if ($vehicle->getSituation() === $this) 
            {

                $vehicle->setSituation(null);

            }
        }

        return $this;

    }

    /**
     * Get the default user location
     *
     * @return boolean|null
     */
    public function getDefaultUserLocation(): ?bool
    {

        return $this->defaultUserLocation;

    }

    /**
     * Set the default user location
     *
     * @param boolean|null $defaultUserLocation
     * @return self
     */
    public function setDefaultUserLocation(?bool $defaultUserLocation): self
    {

        $this->defaultUserLocation = $defaultUserLocation;

        return $this;

    }
    
}
