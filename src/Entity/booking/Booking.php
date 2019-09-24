<?php

namespace App\Entity\booking;

use App\Entity\user\User;
use App\Entity\rating\Rating;
use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\communication\Mail;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\booking\BookingRepository")
 * 
 * @UniqueEntity(
 *               fields={"beginAt"},
 *               message="A booking already exists with this beginning date."
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
     *      message = "The begining date caun't be empty."
     * )
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank(
     *      message = "The end date caun't be empty."
     * )
     * @Assert\Type("\DateTime")
     * @Assert\GreaterThanOrEqual("today")
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="booking")
     * @OrderBy({"createdAt" = "DESC"})
     */
    private $ratings;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->createdAt = new \DateTime();
        $this->ratings = new ArrayCollection();

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
     * Get the beginning date
     *
     * @return \DateTimeInterface|null
     */
    public function getBeginAt(): ?\DateTimeInterface
    {

        return $this->beginAt;
        
    }
    
    /**
     * Get the formatted beginning date
     *
     * @return string
     */
    public function getFormattedBeginAt(): string
    {

        return $this->beginAt->format('d-m-Y');

    }

    /**
     * Set the beginning date
     *
     * @param \DateTimeInterface $beginAt
     * 
     * @return self
     */
    public function setBeginAt(\DateTimeInterface $beginAt): self
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
     * Get the formatted end date
     *
     * @return string
     */
    public function getFormattedEndAt(): string
    {

        return $this->endAt->format('d-m-Y');

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
     * Get the title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }

    /**
     * Set the title
     *
     * @param string $title
     * 
     * @return self
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;

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
     * @param Vehicle|null $vehicle
     * 
     * @return self
     */
    public function setVehicle(?Vehicle $vehicle): self
    {

        $this->vehicle = $vehicle;

        return $this;

    }

    /**
     * Get the user who request the booking
     *
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * Set the user who request the booking
     *
     * @param User|null $user
     * 
     * @return self
     */
    public function setUser(?User $user): self
    {

        $this->user = $user;

        return $this;

    }

    /**
     * Get if the request is accepted
     *
     * @return boolean|null
     */
    public function getAccepted(): ?bool
    {

        return $this->accepted;

    }

    /**
     * Set if the request is accepted
     *
     * @param boolean|null $accepted
     * 
     * @return self
     */
    public function setAccepted(?bool $accepted): self
    {

        $this->accepted = $accepted;

        return $this;

    }

    /**
     * Get if the request is refused
     *
     * @return boolean|null
     */
    public function getRefused(): ?bool
    {

        return $this->refused;

    }

    /**
     * Set if the request is refused
     *
     * @param boolean|null $refused
     * 
     * @return self
     */
    public function setRefused(?bool $refused): self
    {

        $this->refused = $refused;

        return $this;

    }

    /**
     * Get the creation date
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {

        return $this->createdAt;

    }

    /**
     * Set the creation date
     *
     * @param \DateTimeInterface $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the formatted creation date
     *
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y H:m');

    }

    /**
     * Get the user mail
     *
     * @return Mail|null
     */
    public function getUserMail(): ?Mail
    {

        return $this->userMail;

    }

    /**
     * Set the user mail
     *
     * @param Mail $userMail
     * 
     * @return self
     */
    public function setUserMail(Mail $userMail): self
    {

        $this->userMail = $userMail;

        return $this;

    }

    /**
     * Get the owner mail
     *
     * @return Mail|null
     */
    public function getOwnerMail(): ?Mail
    {

        return $this->ownerMail;

    }

    /**
     * Set the owner mail
     *
     * @param Mail|null $ownerMail
     * 
     * @return self
     */
    public function setOwnerMail(?Mail $ownerMail): self
    {

        $this->ownerMail = $ownerMail;

        return $this;

    }

    /**
     * Get mails linked to this booking
     *
     * @return Collection|Mail[]
     */
    public function getMails(): Collection
    {

        return $this->mails;

    }

    /**
     * Add a mail linked to this booking
     *
     * @param Mail $mail
     * 
     * @return self
     */
    public function addMail(Mail $mail): self
    {

        if (!$this->mails->contains($mail)) 
        {

            $this->mails[] = $mail;
            $mail->setBooking($this);

        }

        return $this;

    }

    /**
     * Remove a mail linked to this booking
     *
     * @param Mail $mail
     * 
     * @return self
     */
    public function removeMail(Mail $mail): self
    {

        if ($this->mails->contains($mail)) 
        {

            $this->mails->removeElement($mail);

            // set the owning side to null (unless already changed)
            if ($mail->getBooking() === $this) 
            {

                $mail->setBooking(null);

            }

        }

        return $this;

    }

    /**
     * Get ratings linked to this booking
     *
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {

        return $this->ratings;

    }

    /**
     * Add a rating linked to this booking
     *
     * @param Rating $rating
     * 
     * @return self
     */
    public function addRating(Rating $rating): self
    {

        if (!$this->ratings->contains($rating)) 
        {

            $this->ratings[] = $rating;
            $rating->setBooking($this);

        }

        return $this;

    }

    /**
     * Remove a rating linked to this booking
     *
     * @param Rating $rating
     * 
     * @return self
     */
    public function removeRating(Rating $rating): self
    {

        if ($this->ratings->contains($rating)) 
        {

            $this->ratings->removeElement($rating);

            // set the owning side to null (unless already changed)
            if ($rating->geBooking() === $this) 
            {

                $rating->setBooking(null);

            }

        }

        return $this;

    } 

    /**
     * Get if the booking is removed
     *
     * @return boolean|null
     */
    public function getDeleted(): ?bool
    {

        return $this->deleted;

    }

    /**
     * Set if the booking is removed
     *
     * @param boolean $deleted
     * 
     * @return self
     */
    public function setDeleted(bool $deleted): self
    {

        $this->deleted = $deleted;

        return $this;

    }
    
}
