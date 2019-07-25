<?php

namespace App\Entity\advert;

use App\Entity\communication\Mail;
use App\Entity\advert\Vehicle;
use App\Entity\user\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\BookingRepository")
 * 
 * @UniqueEntity(
 *               fields={"beginAt"},
 *               message="Une réservation existe déjà avec cette date de début."
 * )
 */
class Booking
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
     *      message = "The begining date caun't empty."
     * )
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThan("today")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank(
     *      message = "The end date caun't empty."
     * )
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThan("today")
     * @Assert\GreaterThan(propertyPath="beginAt")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Vehicle", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="bookings")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $refused;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\communication\Mail", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userMail;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\communication\Mail", cascade={"persist"})
     */
    private $ownerMail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="booking", cascade={"persist"})
     */
    private $mails;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function getFormattedBeginAt(): string
    {

        return $this->beginAt->format('d-m-Y');

    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getFormattedEndAt(): string
    {

        return $this->endAt->format('d-m-Y');

    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(?bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getRefused(): ?bool
    {
        return $this->refused;
    }

    public function setRefused(?bool $refused): self
    {
        $this->refused = $refused;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y H:m');

    }

    public function getUserMail(): ?Mail
    {
        return $this->userMail;
    }

    public function setUserMail(Mail $userMail): self
    {
        $this->userMail = $userMail;

        return $this;
    }

    public function getOwnerMail(): ?Mail
    {
        return $this->ownerMail;
    }

    public function setOwnerMail(?Mail $ownerMail): self
    {
        $this->ownerMail = $ownerMail;

        return $this;
    }

    /**
     * @return Collection|Mail[]
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mail $mail): self
    {
        if (!$this->mails->contains($mail)) {
            $this->mails[] = $mail;
            $mail->setBooking($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): self
    {
        if ($this->mails->contains($mail)) {
            $this->mails->removeElement($mail);
            // set the owning side to null (unless already changed)
            if ($mail->getBooking() === $this) {
                $mail->setBooking(null);
            }
        }

        return $this;
    }
}
