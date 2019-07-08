<?php

namespace App\Entity\rating;

use App\Entity\user\User;
use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\rating\RatingRepository")
 */
class Rating
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="sentRatings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(
     *     value = 0
     * )
     * @Assert\LessThan(
     *     value = 6
     * )
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="ratings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $advert;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\DateTime()
     * @Assert\LessThanOrEqual("today")
     */
    private $rentalBeginning;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\DateTime()
     * @Assert\GreaterThanOrEqual(propertyPath="rentalBeginning")
     */
    private $rentalEnd;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     * 
     * @Assert\Choice({"Yes", "No"})
     */
    private $rentalConfirmation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ratingApproved;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $responseApproved;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $response;

    /**
     * @ORM\Column(type="string", length=6)
     * 
     * @Assert\Choice({"User", "Advert"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="receivedRatings")
     */
    private $tenant;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $automaticallyConfirmedRental;

    public function __construct() 
	{
        
        $this->createdAt = new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

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

    public function getRentalBeginning(): ?\DateTimeInterface
    {
        return $this->rentalBeginning;
    }

    public function setRentalBeginning(\DateTimeInterface $rentalBeginning): self
    {
        $this->rentalBeginning = $rentalBeginning;

        return $this;
    }

    public function getRentalEnd(): ?\DateTimeInterface
    {
        return $this->rentalEnd;
    }

    public function setRentalEnd(\DateTimeInterface $rentalEnd): self
    {
        $this->rentalEnd = $rentalEnd;

        return $this;
    }

    public function getRentalConfirmation(): ?string
    {
        return $this->rentalConfirmation;
    }

    public function setRentalConfirmation(?string $rentalConfirmation): self
    {
        $this->rentalConfirmation = $rentalConfirmation;

        return $this;
    }

    public function getRatingApproved(): ?bool
    {
        return $this->ratingApproved;
    }

    public function setRatingApproved(?bool $ratingApproved): self
    {
        $this->ratingApproved = $ratingApproved;

        return $this;
    }

    public function getResponseApproved(): ?bool
    {
        return $this->responseApproved;
    }

    public function setResponseApproved(?bool $responseApproved): self
    {
        $this->responseApproved = $responseApproved;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTenant(): ?User
    {
        return $this->tenant;
    }

    public function setTenant(?User $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getAutomaticallyConfirmedRental(): ?bool
    {
        return $this->automaticallyConfirmedRental;
    }

    public function setAutomaticallyConfirmedRental(?bool $automaticallyConfirmedRental): self
    {
        $this->automaticallyConfirmedRental = $automaticallyConfirmedRental;

        return $this;
    }
}
