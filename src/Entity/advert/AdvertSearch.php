<?php

namespace App\Entity\advert;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

Class AdvertSearch
{

    /**
     * @var int|null
     */
    private $minimumBedsNumber;

    /**
     * @var int|null
     * 
     * @Assert\Range(min=0, max=500)
     */
    private $minimumPrice;

    /**
     * @var int|null
     * 
     * @Assert\Range(min=0, max=500)
     */
    private $maximumPrice;

    /**
     * @var ArrayCollection
     */
    private $cellEquipments;

    /**
     * @var ArrayCollection
     */
    private $carrierEquipments;

    /**
     * @var Float|null
     */
    private $latitude;

    /**
     * @var Float|null
     */
    private $longitude;

    /**
     * @var Integer|null
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "The distance must be greater or equal than {{ value }} km."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 100,
     *     message = "The power distance be less or equal than {{ value }} km."
     * )
     */
    private $distance;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     * @Assert\Choice({"Proximité", "Prix", "Proximité + prix"})
     */
    private $sorting;

    /**
     * @var DateTime|null
     * 
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $beginAt; 

    /**
     * @var DateTime|null
     * 
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThanOrEqual("today")
     * @Assert\GreaterThan(propertyPath="beginAt")
     */
    private $endAt;

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->cellEquipments = new ArrayCollection();
        $this->carrierEquipments = new ArrayCollection();

    }

    /**
     * Set the minimum beds number
     *
     * @param integer|null $minimumBedsNumber
     * 
     * @return AdvertSearch
     */
    public function setMinimumBedsNumber(?int $minimumBedsNumber): AdvertSearch
    {

        $this->minimumBedsNumber = $minimumBedsNumber;

        return $this;

    }

    /**
     *  Get the minimum beds number
     *
     * @return integer|null
     */
    public function getMinimumBedsNumber(): ?int
    {

        return $this->minimumBedsNumber;

    }

    /**
     *  Set the maximum price
     *
     * @param integer|null $maximumPrice
     * 
     * @return AdvertSearch
     */
    public function setMaximumPrice(?int $maximumPrice): AdvertSearch
    {

        $this->maximumPrice = $maximumPrice;

        return $this;

    }

    /**
     * Get the maximum price
     *
     * @return integer|null
     */
    public function getMaximumPrice(): ?int
    {

        return $this->maximumPrice;

    }

    /**
     *  Set the minimum price
     *
     * @param integer|null $minimumPrice
     * 
     * @return AdvertSearch
     */
    public function setMinimumPrice(?int $minimumPrice): AdvertSearch
    {

        $this->minimumPrice = $minimumPrice;

        return $this;

    }

    /**
     * Get the minimum price
     *
     * @return integer|null
     */
    public function getMinimumPrice(): ?int
    {

        return $this->minimumPrice;

    }

    /**
     * Set the cell equipments desired
     *
     * @param ArrayCollection $cellEquipments
     * 
     * @return void
     */
    public function setCellEquipments(ArrayCollection $cellEquipments): void
    {

        $this->cellEquipments = $cellEquipments;

    }

    /**
     * Get the cell equipments desired
     *
     * @return ArrayCollection
     */
    public function getCellEquipments(): ArrayCollection
    {

        return $this->cellEquipments;

    }

    /**
     * Get the carrier equipments desired
     *
     * @param ArrayCollection $carrierEquipments
     * 
     * @return void
     */
    public function setCarrierEquipments(ArrayCollection $carrierEquipments): void
    {

        $this->carrierEquipments = $carrierEquipments;

    }

    /**
     * Set the carrier equipments desired
     *
     * @return ArrayCollection
     */
    public function getCarrierEquipments(): ArrayCollection
    {

        return $this->carrierEquipments;

    }

    /**
     * Set the user's latitude
     *
     * @param float|null $latitude
     * 
     * @return AdvertSearch
     */
    public function setLatitude(?float $latitude): AdvertSearch
    {

        $this->latitude = $latitude;

        return $this;

    }

    /**
     * Get the user's latitude
     *
     * @return float|null
     */
    public function getLatitude(): ?float
    {

        return $this->latitude;

    }

    /**
     * Set the user's longitude
     *
     * @param float|null $longitude
     * 
     * @return AdvertSearch
     */
    public function setLongitude(?float $longitude): AdvertSearch
    {

        $this->longitude = $longitude;

        return $this;

    }

    /**
     * Get the user's longitude
     *
     * @return float|null
     */
    public function getLongitude(): ?float
    {

        return $this->longitude;

    }

    /**
     * Set the maximum distance
     *
     * @param float|null $distance
     * 
     * @return AdvertSearch
     */
    public function setDistance(?float $distance): AdvertSearch
    {

        $this->distance = $distance;

        return $this;

    }

    /**
     * Get the maximum distance
     *
     * @return integer|null
     */
    public function getDistance(): ?int
    {

        return $this->distance;

    }

    /**
     * Set the user's address
     *
     * @param string|null $address
     * 
     * @return AdvertSearch
     */
    public function setAddress(?string $address): AdvertSearch
    {

        $this->address = $address;

        return $this;

    }

    /**
     * Get the user's address
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {

        return $this->address;

    }

    /**
     * Set the user's city
     *
     * @param string|null $city
     * 
     * @return AdvertSearch
     */
    public function setCity(?string $city): AdvertSearch
    {

        $this->city = $city;
        return $this;

    }

    /**
     * Get the user's city
     *
     * @return string|null
     */
    public function getCity(): ?string
    {

        return $this->city;

    }

    /**
     * Set the sorting criterion
     *
     * @param string|null $sorting
     * 
     * @return AdvertSearch
     */
    public function setSorting(?string $sorting): AdvertSearch
    {

        $this->sorting = $sorting;

        return $this;

    }

   /**
    * Get the sorting criterion
    *
    * @return string|null
    */
    public function getSorting(): ?string
    {

        return $this->sorting;

    }

    /**
     * Get the beginning date
     *
     * return \DateTimeInterface|null
     */
    public function getBeginAt(): ?\DateTimeInterface
    {

        return $this->beginAt;
        
    }

    /**
     * Set the beginning date
     *
     * @param \DateTimeInterface $beginAt
     * 
     * @return self
     */
    public function setBeginAt(?\DateTimeInterface $beginAt): self
    {

        $this->beginAt = $beginAt;

        return $this;

    }

    /**
     * Get the end date
     *
     * @return \DateTimeInterface|null
     */
    public function getEndAt(): ?\DateTimeInterface
    {

        return $this->endAt;

    }

    /**
     * Set the end date
     *
     * @param \DateTimeInterface|null $endAt
     * 
     * @return self
     */
    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Set an attribute
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

}