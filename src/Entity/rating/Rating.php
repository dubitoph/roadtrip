<?php

namespace App\Entity\rating;

use App\Entity\user\User;
use App\Entity\advert\Advert;
use App\Entity\booking\Booking;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\rating\ResponseToRating;
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
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "The comment must contain at least {{ limit }} characters",
     *      maxMessage = "The comment cannot contain more than {{ limit }} characters"
     * )
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ratingApproved;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\booking\Booking", inversedBy="ratings")
     */
    private $booking;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\rating\ResponseToRating", mappedBy="rating", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $responseToRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="ratings")
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="createdRatings")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="receivedRatings")
     */
    private $tenant;


    /**
     * The constructor
     */
    public function __construct() 
	{
        
        $this->createdAt = new \DateTime();

    }

    /**
     * Get the id
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get the comment
     *
     * @return string|null
     */
    public function getComment(): ?string
    {

        return $this->comment;

    }

    /**
     * Set the comment
     *
     * @param string|null $comment
     * @return self
     */
    public function setComment(?string $comment): self
    {

        $this->comment = $comment;

        return $this;

    }

    /**
     * Get the score
     *
     * @return integer|null
     */
    public function getScore(): ?int
    {

        return $this->score;
    }

    /**
     * Set the score
     *
     * @param integer|null $score
     * 
     * @return self
     */
    public function setScore(?int $score): self
    {

        $this->score = $score;

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
     * Get the formatted creation date
     *
     * @return \DateTimeInterface|null
     */
    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    /**
     * Set the creation date
     *
     * @param \DateTimeInterface $createdAt
     * 
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {

        $this->createdAt = $createdAt;

        return $this;

    }

    /**
     * Get if the rating is approfed
     *
     * @return boolean|null
     */
    public function getRatingApproved(): ?bool
    {

        return $this->ratingApproved;

    }

    /**
     * Set if the rating is approfed
     *
     * @param boolean|null $ratingApproved
     * 
     * @return self
     */
    public function setRatingApproved(?bool $ratingApproved): self
    {

        $this->ratingApproved = $ratingApproved;

        return $this;

    }

    /**
     * Get the booking
     *
     * @return Booking|null
     */
    public function getBooking(): ?Booking
    {

        return $this->booking;

    }

    /**
     * Set the booking
     *
     * @param Booking|null $booking
     * @return self
     */
    public function setBooking(?Booking $booking): self
    {

        $this->booking = $booking;

        return $this;

    }

    /**
     * Get the response
     *
     * @return ResponseToRating|null
     */
    public function getResponseToRating(): ?ResponseToRating
    {

        return $this->responseToRating;

    }

    /**
     * Set the response
     *
     * @param ResponseToRating|null $responseToRating
     * 
     * @return self
     */
    public function setResponseToRating(?ResponseToRating $responseToRating): self
    {

        $this->responseToRating = $responseToRating;
/*
        // set the owning side of the relation if necessary
        if ($this !== $responseToRating->getRating()) {
            $responseToRating->setRating($this);
        }
*/
        return $this;

    }

    /**
     * Get the advert
     *
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    /**
     * Set the advert
     *
     * @param Advert|null $advert
     * 
     * @return self
     */
    public function setAdvert(?Advert $advert): self
    {

        $this->advert = $advert;

        return $this;

    }

    /**
     * Get the user who create the rating
     *
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * Set the user who create the rating
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
     * Get the tenant
     *
     * @return User|null
     */
    public function geTenant(): ?User
    {

        return $this->tenant;

    }

    /**
     * Set the tenant
     *
     * @param User|null $tenant
     * @return self
     */
    public function setTenant(?User $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }
}
