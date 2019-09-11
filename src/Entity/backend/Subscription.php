<?php

namespace App\Entity\backend;

use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 1,
     *     message = "The duration must be greather or equal than {{ value }}."
     * )
     * @Assert\LessThanOrEqual(
     *     value = 12,
     *     message = "The duration must be less or equal than {{ value }}."
     * )
     * @Assert\NotBlank(
     *      message = "The duration can't be empty."
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Advert", mappedBy="subscription")
     */
    private $adverts;
 
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeProductId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripePlanId;

    public function __construct()
    {
        $this->adverts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setSubscription($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getSubscription() === $this) {
                $advert->setSubscription(null);
            }
        }

        return $this;
    }
 
    /**
     * Get isActive
     *
     * @return void
     */
    public function getIsActive()
    {

        return $this->isActive;

    }
 
    /**
     * Set isActive
     *
     * @param [type] $isActive
     * @return void
     */
    public function setIsActive($isActive)
    {

        $this->isActive = $isActive;

        return $this;

    }

    /**
     * Get the Stripe product id
     *
     * @return string|null
     */
    public function getStripeProductId(): ?string
    {

        return $this->stripeProductId;

    }

    /**
     * Set the Stripe product id
     *
     * @param string $stripeProductId
     * @return self
     */
    public function setStripeProductId(string $stripeProductId): self
    {

        $this->stripeProductId = $stripeProductId;

        return $this;

    }

    /**
     * Get the Stripe plan id
     *
     * @return string|null
     */
    public function getStripePlanId(): ?string
    {

        return $this->stripePlanId;

    }

    /**
     * Set the Stripe plan id
     *
     * @param string $stripePlanId
     * @return self
     */
    public function setStripePlanId(string $stripePlanId): self
    {

        $this->stripePlanId = $stripePlanId;

        return $this;

    }
    
}
