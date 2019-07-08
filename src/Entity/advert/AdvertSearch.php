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
     * @Assert\Range(min=0, max=2000)
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

    public function __construct()
    {

        $this->cellEquipments = new ArrayCollection();
        $this->carrierEquipments = new ArrayCollection();

    }

    /**
     * @param int|null $minimumBedsNumber
     * @return AdvertSearch
     */
    public function setMinimumBedsNumber(?int $minimumBedsNumber): AdvertSearch
    {

        $this->minimumBedsNumber = $minimumBedsNumber;
        return $this;

    }

    /**
     * @return int|null $minimumBedsNumber
     */
    public function getMinimumBedsNumber(): ?int
    {

        return $this->minimumBedsNumber;

    }

    /**
     * @param int|null $maximumPrice
     * @return AdvertSearch
     */
    public function setMaximumPrice(?int $maximumPrice): AdvertSearch
    {

        $this->maximumPrice = $maximumPrice;
        return $this;

    }

    /**
     * @return int|null $maximumPrice
     */
    public function getMaximumPrice(): ?int
    {

        return $this->maximumPrice;

    }

    /**
     * @param ArrayCollection $cellEquipments
     */
    public function setCellEquipments(ArrayCollection $cellEquipments): void
    {

        $this->cellEquipments = $cellEquipments;

    }

    /**
     * @return ArrayCollection 
     */
    public function getCellEquipments(): ArrayCollection
    {

        return $this->cellEquipments;

    }

    /**
     * @param ArrayCollection $carrierEquipments
     */
    public function setCarrierEquipments(ArrayCollection $carrierEquipments): void
    {

        $this->carrierEquipments = $carrierEquipments;

    }

    /**
     * @return ArrayCollection 
     */
    public function getCarrierEquipments(): ArrayCollection
    {

        return $this->carrierEquipments;

    }

    /**
     * @param float|null $latitude
     * @return AdvertSearch
     */
    public function setLatitude(?float $latitude): AdvertSearch
    {

        $this->latitude = $latitude;
        return $this;

    }

    /**
     * @return float|null $latitude
     */
    public function getLatitude(): ?float
    {

        return $this->latitude;

    }

    /**
     * @param float|null $longitude
     * @return AdvertSearch
     */
    public function setLongitude(?float $longitude): AdvertSearch
    {

        $this->longitude = $longitude;
        return $this;

    }

    /**
     * @return float|null $longitude
     */
    public function getLongitude(): ?float
    {

        return $this->longitude;

    }

    /**
     * @param int|null $distance
     * @return AdvertSearch
     */
    public function setDistance(?float $distance): AdvertSearch
    {

        $this->distance = $distance;
        return $this;

    }

    /**
     * @return int|null $distance
     */
    public function getDistance(): ?int
    {

        return $this->distance;

    }

    /**
     * @param string|null $address
     * @return AdvertSearch
     */
    public function setAddress(?string $address): AdvertSearch
    {

        $this->address = $address;
        return $this;

    }

    /**
     * @return string|null $address
     */
    public function getAddress(): ?string
    {

        return $this->address;

    }

    /**
     * @param string|null $city
     * @return AdvertSearch
     */
    public function setCity(?string $city): AdvertSearch
    {

        $this->city = $city;
        return $this;

    }

    /**
     * @return string|null $city
     */
    public function getCity(): ?string
    {

        return $this->city;

    }

    /**
     * Set sorting
     *
     * @param string|null $sorting
     * @return AdvertSearch
     */
    public function setSorting(?string $sorting): AdvertSearch
    {

        $this->sorting = $sorting;
        return $this;

    }

    /**
     * Get sorting
     *
     * @return string|null
     */
    public function getSorting(): ?string
    {

        return $this->sorting;

    }

}