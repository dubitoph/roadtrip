<?php

namespace App\Entity\advert;

use App\Entity\backend\Fuel;
use App\Entity\backend\Mark;
use App\Entity\backend\Sort;
use App\Entity\advert\Advert;
use App\Entity\booking\Booking;
use App\Entity\address\Address;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\backend\Equipment;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank(
     *      message = "The building date can't be empty"
     * )
     * @Assert\Type("\DateTime")
     * @Assert\LessThan(
     *      "today",
     *      message = "The building date must be less or equal than today."
     * )
     */
    private $manufactureDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Sort", inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Sort")
     * @Assert\Valid()
     * @Assert\NotBlank(
     *      message = "The sort can't be empty."
     * )
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Fuel", inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\Backend\Fuel")
     * @Assert\Valid()
     * @Assert\NotBlank(
     *      message = "The sort can't be empty."
     * )
     */
    private $fuel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Mark", inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Mark")
     * @Assert\Valid()
     * @Assert\NotBlank(
     *      message = "The mark can't be empty."
     * )
     */
    private $mark;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "The beds number must be greather or equal than {{ value }}."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 10,
     *     message = "The beds number must be less or equal than {{ value }}."
     * )
     * @Assert\NotBlank(
     *      message = "The beds number can't be empty."
     * )
     */
    private $bedsNumber;

    /**
     * @ORM\Column(type="smallint") 
     *  
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "The seats number must be greather or equal than {{ value }}."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 10,
     *     message = "The seats number must be less or equal than {{ value }}."
     * )
     * @Assert\NotBlank(
     *      message = "The seats number can't be empty."
     * )
     */
    private $seatsNumber;

    /**
     * @ORM\Column(type="decimal", scale=2, precision=3, nullable=true)
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 2,
     *     message = "The length must be greater or equal than {{ value }} m."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 7,
     *     message = "The length must be less or equal than {{ value }} m."
     * )
     */
    private $length;

    /**
     * @ORM\Column(type="decimal", scale=2, precision=3, nullable=true)
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 1.5,
     *     message = "The height must be greater or equal than {{ value }} m."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 5,
     *     message = "The height must be less or equal than {{ value }} m."
     * )
     */
    private $height;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 200,
     *     message = "The weight must be greater or equal than {{ value }} kg."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 15000,
     *     message = "The weight must be less or equal than {{ value }} kg."
     * )
     */
    private $weight;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 70,
     *     message = "The power must be greater or equal than {{ value }} cv."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 600,
     *     message = "The power must be less or equal than {{ value }} cv."
     * )
     */
    private $power;

    /**
     * @var string
     *
     * @ORM\Column(name="gearbox", type="string", length=25)
     * 
     * @Assert\Choice({"Automatic", "Manual"})
     */
    private $gearbox;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\advert\Advert", mappedBy="vehicle")
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\backend\Equipment", inversedBy="vehicles", cascade={"remove", "persist"})
     */
    private $equipments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\address\Address", inversedBy="vehicle", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\address\Address")
     * @Assert\Valid()
     */
    private $situation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\booking\Booking", mappedBy="vehicle", orphanRemoval=true)
     */
    private $bookings;

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->equipments = new ArrayCollection();
        $this->bookings = new ArrayCollection();

    }

    /**
     * Get a string to describe the vehicle
     *
     * @return string
     */
    public function __toString(): string
    {

        return $this->mark->getMark() . ' -' . $this->sort->getSort() . ' (' . $this->getFormattedManufactureDate() . ')';

    }

    /**
     * Get de vehicle id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get the manufacture date
     *
     * @return \DateTimeInterface|null
     */
    public function getManufactureDate(): ?\DateTimeInterface
    {

        return $this->manufactureDate;

    }

    /**
     * Get a string of the manufacture date
     *
     * @return string
     */
    public function getFormattedManufactureDate(): string
    {

        return $this->manufactureDate->format('d-m-Y');

    }

    /**
     * Set the manufacture date
     *
     * @param \DateTimeInterface $manufactureDate
     * @return self
     */
    public function setManufactureDate(\DateTimeInterface $manufactureDate): self
    {

        $this->manufactureDate = $manufactureDate;

        return $this;

    }

    /**
     * Get the sort
     *
     * @return Sort|null
     */
    public function getSort(): ?Sort
    {

        return $this->sort;

    }

    /**
     * Set the sort
     *
     * @param Sort|null $sort
     * @return self
     */
    public function setSort(?Sort $sort): self
    {

        $this->sort = $sort;

        return $this;

    }

    /**
     * Get the fuel
     *
     * @return Fuel|null
     */
    public function getFuel(): ?Fuel
    {

        return $this->fuel;

    }

    /**
     * Set the fuel
     *
     * @param Fuel|null $fuel
     * @return self
     */
    public function setFuel(?Fuel $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * Get the mark
     *
     * @return Mark|null
     */
    public function getMark(): ?Mark
    {

        return $this->mark;

    }

    /**
     * Set the mark
     *
     * @param Mark|null $mark
     * @return self
     */
    public function setMark(?Mark $mark): self
    {

        $this->mark = $mark;

        return $this;

    }

    /**
     * Get the beds number
     *
     * @return integer|null
     */
    public function getBedsNumber(): ?int
    {

        return $this->bedsNumber;

    }

    /**
     * Get the beds number
     *
     * @param integer $bedsNumber
     * @return self
     */
    public function setBedsNumber(int $bedsNumber): self
    {

        $this->bedsNumber = $bedsNumber;

        return $this;

    }

    /**
     * Get the seats number
     *
     * @return integer|null
     */
    public function getSeatsNumber(): ?int
    {

        return $this->seatsNumber;

    }

    /**
     * Get the seats number
     *
     * @param integer $seatsNumber
     * @return self
     */
    public function setSeatsNumber(int $seatsNumber): self
    {

        $this->seatsNumber = $seatsNumber;

        return $this;

    }

    /**
     * Set the length
     *
     * @return float|null
     */
    public function getLength(): ?float
    {

        return $this->length;

    }

    /**
     * Get the length
     *
     * @param float $length
     * @return self
     */
    public function setLength(float $length): self
    {

        $this->length = $length;

        return $this;

    }

    /**
     * Get the height
     *
     * @return float|null
     */
    public function getHeight(): ?float
    {

        return $this->height;

    }

    /**
     * Set the height
     *
     * @param float $height
     * @return self
     */
    public function setHeight(float $height): self
    {

        $this->height = $height;

        return $this;

    }

    /**
     * Get the weight
     *
     * @return integer|null
     */
    public function getWeight(): ?int
    {

        return $this->weight;

    }

    /**
     * Set the weight
     *
     * @param integer $weight
     * @return self
     */
    public function setWeight(int $weight): self
    {

        $this->weight = $weight;

        return $this;

    }

    /**
     * Get the power
     *
     * @return integer|null
     */
    public function getPower(): ?int
    {

        return $this->power;

    }

    /**
     * Set the power
     *
     * @param integer $power
     * @return self
     */
    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get the gearbox type
     *
     * @return string|null
     */
    public function getGearbox(): ?string
    {

        return $this->gearbox;

    }

    /**
     * Set the gearbox type
     *
     * @param string $gearbox
     * @return self
     */
    public function setGearbox(string $gearbox): self
    {

        $this->gearbox = $gearbox;

        return $this;

    }

    /**
     * Get the advert containing the vehicle
     *
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {

        return $this->advert;

    }

    /**
     * Set the advert containing the vehicle
     *
     * @param Advert $advert
     * @return self
     */
    public function setAdvert(Advert $advert): self
    {

        $this->advert = $advert;

        // set the owning side of the relation if necessary
        if ($this !== $advert->getVehicle()) 
        {

            $advert->setVehicle($this);

        }

        return $this;

    }

    /**
     * Get equipments
     *
     * @return Collection
     */
    public function getEquipments(): Collection
    {

        return $this->equipments;

    }

    /**
     * Set equipments
     *
     * @param ArrayCollection $equipments
     * @return void
     */
    public function setEquipments(ArrayCollection $equipments)
    {

        $this->equipments = $equipments;

    }

    /**
     * Add equipment
     *
     * @param Equipment $equipment
     * @return self
     */
    public function addEquipment(Equipment $equipment): self
    {

        if (!$this->equipments->contains($equipment)) 
        {

            $this->equipments[] = $equipment;
            $equipment->addVehicle($this);

        }

        return $this;

    }

    /**
     * Remove an equipment
     *
     * @param Equipment $equipment
     * @return self
     */
    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) 
        {

            $this->equipments->removeElement($equipment);
            $equipment->removeVehicle($this);

        }

        return $this;
    }

    /**
     * Get cell equipments
     *
     * @return Collection|Equipment[]
     */
     public function getCellEquipments(): Collection
    {

        return $this->cellEquipments;

    }

    /**
     * Set cell equipments
     *
     * @param ArrayCollection $cellEquipments
     * @return void
     */
    public function setCellEquipments(ArrayCollection $cellEquipments)
    {

        $this->cellEquipments = $cellEquipments;

    }

    /**
     * Add an cell equipment
     *
     * @param Equipment $cellEquipment
     * @return self
     */
    public function addCellEquipment(Equipment $cellEquipment): self
    {

        if (!$this->cellEquipments->contains($cellEquipment)) 
        {

            $this->cellEquipments[] = $cellEquipment;
            $cellEquipment->addVehicle($this);

        }

        return $this;

    }

    /**
     * Remove a cell equipment
     *
     * @param Equipment $cellEquipment
     * @return self
     */
    public function removeCellEquipment(Equipment $cellEquipment): self
    {

        if ($this->cellEquipments->contains($cellEquipment)) 
        {

            $this->cellEquipments->removeElement($cellEquipment);
            $cellEquipment->removeVehicle($this);

        }

        return $this;

    }
    
    /**
     * Get the vehicle address situation
     *
     * @return Address|null
     */
    public function getSituation(): ?Address
    {

        return $this->situation;

    }

    /**
     * Set the vehicle address situation
     *
     * @param Address|null $situation
     * @return self
     */
    public function setSituation(?Address $situation): self
    {

        $this->situation = $situation;
        $situation->setVehicle($this);

        return $this;

    }

    /**
     * Get vehicle related bookings
     *
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {

        return $this->bookings;
        
    }

    /**
     * Add a booking
     *
     * @param Booking $booking
     * @return self
     */
    public function addBooking(Booking $booking): self
    {

        if (!$this->bookings->contains($booking)) 
        {

            $this->bookings[] = $booking;
            $booking->setVehicle($this);

        }

        return $this;

    }

    /**
     * Remove a booking
     *
     * @param Booking $booking
     * @return self
     */
    public function removeBooking(Booking $booking): self
    {

        if ($this->bookings->contains($booking)) 
        {

            $this->bookings->removeElement($booking);

            // set the owning side to null (unless already changed)
            if ($booking->getVehicle() === $this) 
            {

                $booking->setVehicle(null);

            }

        }

        return $this;

    }
    
}
