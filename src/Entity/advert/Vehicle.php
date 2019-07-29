<?php

namespace App\Entity\advert;

use App\Entity\backend\Fuel;
use App\Entity\backend\Mark;
use App\Entity\backend\Sort;
use App\Entity\advert\Advert;
use App\Entity\advert\Booking;
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
     *      message = "La date de construction ne peut pas être vide."
     * )
     * @Assert\Type("\DateTime")
     * @Assert\LessThan("today")
     */
    private $manufactureDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Sort", inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\backend\Sort")
     * @Assert\Valid()     * 
     * @Assert\NotBlank(
     *      message = "La sorte ne peut pas être vide."
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
     *      message = "Le carburant ne peut pas être vide."
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
     *      message = "La marque ne peut pas être vide."
     * )
     */
    private $mark;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\GreaterThan(
     *     value = 0
     * )
     * @Assert\LessThan(
     *     value = 11
     * )
     * @Assert\NotBlank(
     *      message = "Le nombre de lits ne peut pas être vide."
     * )
     */
    private $bedsNumber;

    /**
     * @ORM\Column(type="integer") 
     * 
     * @Assert\GreaterThan(
     *     value = 0
     * )
     * @Assert\LessThan(
     *     value = 11
     * )
     * @Assert\NotBlank(
     *      message = "Le nombre de sièges ne peut pas être vide."
     * )
     */
    private $seatsNumber;

    /**
     * @ORM\Column(type="float", scale=2, precision=3, nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 2,
     *     message = "La longeur doit être supérieure à 2 m."
     * )
     * @Assert\LessThan(
     *     value = 7,
     *     message = "La longeur doit être inférieure à 7 m."
     * )
     */
    private $length;

    /**
     * @ORM\Column(type="float", scale=2, precision=3, nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 1.5,
     *     message = "La hauteur doit être supérieure à 1.50 m."
     * )
     * @Assert\LessThan(
     *     value = 5,
     *     message = "La hauteur doit être inférieure à 5 m."
     * )
     */
    private $height;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 800,
     *     message = "Le poids doit être supérieur à 800 kg."
     * )
     * @Assert\LessThan(
     *     value = 20000,
     *     message = "Le poids doit être inférieur à 20000 kg."
     * )
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 70,
     *     message = "La puissance doit être supérieure à 70 cv."
     * )
     * @Assert\LessThan(
     *     value = 600,
     *     message = "La puissance doit être inférieure à 600 cv."
     * )
     */
    private $power;

    /**
     * @var string
     *
     * @ORM\Column(name="gearbox", type="string", length=25)
     * 
     * @Assert\Choice({"Automatique", "Manuelle"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Booking", mappedBy="vehicle", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {

        $this->equipments = new ArrayCollection();
        $this->bookings = new ArrayCollection();

    }

    public function __toString()
    {

        return 'whatever you neet to see the type';

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->manufactureDate;
    }

    public function getFormattedManufactureDate(): string
    {
        return $this->manufactureDate->format('d-m-Y');
    }

    public function setManufactureDate(\DateTimeInterface $manufactureDate): self
    {
        $this->manufactureDate = $manufactureDate;

        return $this;
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function setSort(?Sort $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getFuel(): ?Fuel
    {
        return $this->fuel;
    }

    public function setFuel(?Fuel $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getBedsNumber(): ?int
    {
        return $this->bedsNumber;
    }

    public function setBedsNumber(int $bedsNumber): self
    {
        $this->bedsNumber = $bedsNumber;

        return $this;
    }

    public function getSeatsNumber(): ?int
    {
        return $this->seatsNumber;
    }

    public function setSeatsNumber(int $seatsNumber): self
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(Advert $advert): self
    {
        $this->advert = $advert;

        // set the owning side of the relation if necessary
        if ($this !== $advert->getVehicle()) {
            $advert->setVehicle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Equipment[]
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
     * Get equipments
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
     * @return Collection|Equipment[]
     */
    public function getCellEquipments(): Collection
    {
        return $this->cellEquipments;
    }

    public function setCellEquipments(ArrayCollection $cellEquipments)
    {
        $this->cellEquipments = $cellEquipments;
    }

    public function addCellEquipment(Equipment $cellEquipment): self
    {
        if (!$this->cellEquipments->contains($cellEquipment)) 
        {
            $this->cellEquipments[] = $cellEquipment;
            $cellEquipment->addVehicle($this);
        }

        return $this;
    }

    public function removeCellEquipment(Equipment $cellEquipment): self
    {
        if ($this->cellEquipments->contains($cellEquipment)) 
        {
            $this->cellEquipments->removeElement($cellEquipment);
            $cellEquipment->removeVehicle($this);
        }

        return $this;
    }
    
    public function getSituation(): ?Address
    {

        return $this->situation;

    }

    public function setSituation(?Address $situation): self
    {

        $this->situation = $situation;
        $situation->setVehicle($this);

        return $this;

    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setVehicle($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getVehicle() === $this) {
                $booking->setVehicle(null);
            }
        }

        return $this;
    }
}
