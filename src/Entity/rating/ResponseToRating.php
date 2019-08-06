<?php

namespace App\Entity\rating;

use App\Entity\rating\Rating;
use App\Entity\user\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\rating\ResponseToRatingRepository")
 */
class ResponseToRating
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "The response must contain at least {{ limit }} characters",
     *      maxMessage = "The response cannot contain more than {{ limit }} characters"
     * )
     */
    private $response;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $approved;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\rating\Rating", inversedBy="responseToRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rating;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {

        return $this->createdAt;

    }

    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(Rating $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
