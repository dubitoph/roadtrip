<?php

namespace App\Entity\advert;

use App\Entity\rating\Rating;
use App\Entity\communication\Thread;
use App\Entity\user\Favorite;
use App\Entity\user\Owner;
use Cocur\Slugify\Slugify;
use App\Entity\media\Photo;
use App\Entity\advert\Price;
use App\Entity\payment\Bill;
use App\Entity\advert\Period;
use App\Entity\advert\Vehicle;
use App\Entity\advert\Insurance;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\backend\Subscription;
use App\Entity\advert\IncludedMileage;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\AdvertRepository")
 * 
 * @UniqueEntity(
 *               fields={"vehicle"},
 *               message="An advert already exists for this vehicle"
 * )
 */
class Advert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 80,
     *      minMessage = "The title must contain at least {{ limit }} characters",
     *      maxMessage = "Title can't contain more than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Assert\Length(
     *      min = 20,
     *      max = 5000,
     *      minMessage = "The description must contain at least {{ limit }} characters",
     *      maxMessage = "Description can't contain more than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @OrderBy({"createdAt" = "ASC"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiresAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\advert\Vehicle", inversedBy="advert", orphanRemoval=true, cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\Type(type="App\Entity\advert\Vehicle")
     * @Assert\Valid()
     */
    private $vehicle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\media\Photo", mappedBy="advert", orphanRemoval=true, cascade={"persist"})
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Price", mappedBy="advert", orphanRemoval=true, cascade={"persist"}) 
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Period", mappedBy="advert", orphanRemoval=true, cascade={"persist"})
     */
    private $periods;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\advert\Insurance", inversedBy="advert", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\Type(type="App\Entity\advert\Insurance")
     * @Assert\Valid()
     */
    private $insurance;

    /**
     * @ORM\Column(type="float", scale=2, precision=3, nullable=true)
     * 
     * @Assert\LessThan(
     *     value = 2,
     *     message = "Le prix du kilomètre supplémentaire doit être inférieur à 2 €."
     * )
     */
    private $extraKilometerCost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\IncludedMileage", mappedBy="advert", orphanRemoval=true, cascade={"persist"})
     */
    private $includedMileages;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $includedCleaning;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cleaningCost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\Owner", inversedBy="adverts")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\Subscription", inversedBy="adverts")
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\Type(type="App\Entity\backend\Subscription")
     * @Assert\Valid()
     */
    private $subscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeSubscriptionId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\payment\Bill", mappedBy="advert")
     */
    private $bills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\user\Favorite", mappedBy="advert", orphanRemoval=true)
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Thread", mappedBy="advert", orphanRemoval=true)
     */
    private $threads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="advert")
     */
    private $ratings;

    /**
     * Operations when creating
     */
    function __construct() 
	{

        $this->createdAt = new \DateTime();
        $this->photos = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->periods = new ArrayCollection();
        $this->includedMileages = new ArrayCollection();
        $this->mails = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->ratings = new ArrayCollection();

	}    

    /**
     * Get id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;

        return $this;

    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {

        return $this->description;

    }

    /**
     * Set description
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {

        $this->description = $description;

        return $this;

    }

    /**
     * Get the advert creation date
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {

        return $this->createdAt;

    }

    /**
     * Set the advert creation date
     *
     * @param \DateTimeInterface|null $createdAt
     * @return self
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {

        $this->createdAt = $createdAt;

        return $this;
        
    }

    /**
     * Get a string of the creation date
     *
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    /**
     * Get the update date
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {

        return $this->updatedAt;

    }

    /**
     * Get a string of the update date
     *
     * @return string
     */
    public function getFormattedUpdatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    /**
     * Set the update date
     *
     * @param \DateTimeInterface|null $updatedAt
     * @return self
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {

        $this->updatedAt = $updatedAt;

        return $this;

    }

    /**
     * Get the expiration date
     *
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {

        return $this->expiresAt;

    }

    /**
     * Get a string of the expiration date
     *
     * @return string
     */
    public function getFormattedExpiresAt(): string
    {

        if($this->expiresAt)
        {
        
            return $this->expiresAt->format('d-m-Y');

        }
        else 
        {

            return "Not active";

        }

    }

    /**
     * Set the expiration date
     *
     * @param \DateTimeInterface|null $expiresAt
     * @return self
     */
    public function setExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;
                                                                                                                                                                                                                                             
        return $this;

    }

    /**
     * Get the linked vehicle
     *
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {

        return $this->vehicle;

    }

    /**
     * Set the linked vehicle
     *
     * @param Vehicle $vehicle
     * @return self
     */
    public function setVehicle(Vehicle $vehicle = null): self
    {

        $this->vehicle = $vehicle;
        $this->vehicle->setAdvert($this);

        return $this;

    }

    /**
     * Get photos
     *
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {

        return $this->photos;

    }

    /**
     * Set photos
     *
     * @param Collection $photos
     * 
     * @return void
     */
    public function setPhotos(Collection $photos = null)
    {

        $this->photos = $photos;

    }
    
    /**
     * Add a photo
     *
     * @param Photo $photo
     * @return self
     */
    public function addPhoto(Photo $photo): self
    {

        if (!$this->photos->contains($photo)) 
        {

            $this->photos[] = $photo;
            $photo->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a photo
     *
     * @param Photo $photo
     * @return self
     */
    public function removePhoto(Photo $photo): self
    {

        if ($this->photos->contains($photo)) 
        {

            $this->photos->removeElement($photo);

            // set the owning side to null (unless already changed)
            if ($photo->getAdvert() === $this) 
            {

                $photo->setAdvert(null);
                
            }
            
        }

        return $this;

    }

    /**
     * Get rental prices
     *
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {

        return $this->prices;
        
    }

    
    /**
     * Set rental prices
     *
     * @param Price $price
     * @return self
     */
    public function addPrice(Price $price): self
    {

        if (!$this->prices->contains($price)) 
        {

            $this->prices[] = $price;
            $price->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a rental price
     *
     * @param Price $price
     * @return self
     */
    public function removePrice(Price $price): self
    {

        if ($this->prices->contains($price)) 
        {

            $this->prices->removeElement($price);

            // set the owning side to null (unless already changed)
            if ($price->getAdvert() === $this) 
            {

                $price->setAdvert(null);

            }

        }

        return $this;

    }

    /**
     * Get rental periods
     *
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {

        return $this->periods;

    }

    /**
     * Add a rental period
     *
     * @param Period $period
     * @return self
     */
    public function addPeriod(Period $period): self
    {

        if (!$this->periods->contains($period)) 
        {

            $this->periods[] = $period;
            $period->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a rental period
     *
     * @param Period $period
     * @return self
     */
    public function removePeriod(Period $period): self
    {

        if ($this->periods->contains($period)) 
        {

            $this->periods->removeElement($period);

            // set the owning side to null (unless already changed)
            if ($period->getAdvert() === $this) 
            {

                $period->setAdvert(null);

            }

        }

        return $this;

    }

    /**
     * Get the insurance for rental
     *
     * @return Insurance|null
     */
    public function getInsurance(): ?Insurance
    {

        return $this->insurance;

    }

    /**
     * Set the insurance for rental
     *
     * @param Insurance $insurance
     * @return self
     */
    public function setInsurance(Insurance $insurance): self
    {

        $this->insurance = $insurance;

        // set the owning side of the relation if necessary
        if ($this !== $insurance->getAdvert()) 
        {

            $insurance->setAdvert($this);

        }

        return $this;

    }

    /**
     * Get the extra kilometer cost when rental
     *
     * @return float|null
     */
    public function getExtraKilometerCost(): ?float
    {

        return $this->extraKilometerCost;

    }

    /**
     * Set the extra kilometer cost when rental
     *
     * @param float|null $extraKilometerCost
     * @return self
     */
    public function setExtraKilometerCost(?float $extraKilometerCost): self
    {

        $this->extraKilometerCost = $extraKilometerCost;

        return $this;

    }

    /**
     * Get included mileages for rental periods
     *
     * @return Collection|IncludedMileage[]
     */
    public function getIncludedMileages(): Collection
    {

        return $this->includedMileages;

    }

    /**
     * Add an included mileage to rental periods
     *
     * @param IncludedMileage $includedMileage
     * @return self
     */
    public function addIncludedMileage(IncludedMileage $includedMileage): self
    {
        if (!$this->includedMileages->contains($includedMileage)) 
        {

            $this->includedMileages[] = $includedMileage;
            $includedMileage->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove an included mileage from rental periods
     *
     * @param IncludedMileage $includedMileage
     * @return self
     */
    public function removeIncludedMileage(IncludedMileage $includedMileage): self
    {

        if ($this->includedMileages->contains($includedMileage)) 
        {

            $this->includedMileages->removeElement($includedMileage);

            // set the owning side to null (unless already changed)
            if ($includedMileage->getAdvert() === $this) 
            {

                $includedMileage->setAdvert(null);

            }
            
        }

        return $this;

    }

    /**
     * Get if the cleaning is included in the cost rental
     *
     * @return boolean|null
     */
    public function getIncludedCleaning(): ?bool
    {

        return $this->includedCleaning;

    }

    /**
     * Set if the cleaning is included in the cost rental
     *
     * @param boolean $includedCleaning
     * @return self
     */
    public function setIncludedCleaning(bool $includedCleaning): self
    {

        $this->includedCleaning = $includedCleaning;

        return $this;

    }

    /**
     * Get the cleaning cost
     *
     * @return integer|null
     */
    public function getCleaningCost(): ?int
    {
        return $this->cleaningCost;
    }

    /**
     * Set the cleaning cost
     *
     * @param integer|null $cleaningCost
     * @return self
     */
    public function setCleaningCost(?int $cleaningCost): self
    {

        $this->cleaningCost = $cleaningCost;

        return $this;

    }

    /**
     * Get the slug
     *
     * @return string
     */
    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->title);

    }

    /**
     * Get the owner
     *
     * @return Owner|null
     */
    public function getOwner(): ?Owner
    {

        return $this->owner;

    }

    /**
     * Set the owner
     *
     * @param Owner|null $owner
     * @return self
     */
    public function setOwner(?Owner $owner): self
    {

        $this->owner = $owner;

        return $this;

    }

    /**
     * Get the subscription
     *
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {

        return $this->subscription;

    }

    /**
     * Set the subscription
     *
     * @param Subscription|null $subscription
     * @return self
     */
    public function setSubscription(?Subscription $subscription): self
    {

        $this->subscription = $subscription;

        return $this;

    }

    /**
     * Get the Stripe subscription id
     *
     * @return string|null
     */
    public function getStripeSubscriptionId(): ?string
    {

        return $this->stripeSubscriptionId;

    }

    /**
     * Set the Stripe subscription id
     *
     * @param string|null $stripeSubscriptionId
     * @return self
     */
    public function setStripeSubscriptionId(?string $stripeSubscriptionId): self
    {

        $this->stripeSubscriptionId = $stripeSubscriptionId;

        return $this;

    }

    /**
     * Get bills
     *
     * @return Collection|Bill[]
     */
    public function getBills(): Collection
    {

        return $this->bills;

    }

    /**
     * Add a bill
     *
     * @param Bill $bill
     * @return self
     */
    public function addBill(Bill $bill): self
    {

        if (!$this->bills->contains($bill)) 
        {

            $this->bills[] = $bill;
            $bill->setOwner($this);

        }

        return $this;

    }

    /**
     * Remove a bill
     *
     * @param Bill $bill
     * @return self
     */
    public function removeBill(Bill $bill): self
    {

        if ($this->bills->contains($bill)) 
        {

            $this->bills->removeElement($bill);

            // set the owning side to null (unless already changed)
            if ($bill->getOwner() === $this) 
            {

                $bill->setOwner(null);

            }

        }

        return $this;

    }

    /**
     * @return Collection|Favorite[]
     */
    
    /**
     * Get favorites having this advert
     *
     * @return Collection
     */
    public function getFavorites(): Collection
    {

        return $this->favorites;

    }

    /**
     * Add a favorite having this advert
     *
     * @param Favorite $favorite
     * @return self
     */
    public function addFavorite(Favorite $favorite): self
    {
        
        if (!$this->favorites->contains($favorite)) 
        {

            $this->favorites[] = $favorite;
            $favorite->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a favorite having this advert
     *
     * @param Favorite $favorite
     * @return self
     */
    public function removeFavorite(Favorite $favorite): self
    {

        if ($this->favorites->contains($favorite)) 
        {

            $this->favorites->removeElement($favorite);

            // set the owning side to null (unless already changed)
            if ($favorite->getAdvert() === $this) 
            {

                $favorite->setAdvert(null);

            }

        }

        return $this;

    }

    /**
     * Get the threads linked to this advert
     *
     * @return Collection|Thread[]
     */
    public function getThreads(): Collection
    {

        return $this->threads;

    }

    /**
     * Add a thread linked to this advert
     *
     * @param Thread $thread
     * @return self
     */
    public function addThread(Thread $thread): self
    {

        if (!$this->threads->contains($thread)) 
        {

            $this->threads[] = $thread;
            $thread->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a thread linked to this advert
     *
     * @param Thread $thread
     * @return self
     */
    public function removeThread(Thread $thread): self
    {

        if ($this->threads->contains($thread)) 
        {

            $this->threads->removeElement($thread);

            // set the owning side to null (unless already changed)
            if ($thread->getAdvert() === $this) 
            {

                $thread->setAdvert(null);

            }

        }

        return $this;

    }

    /**
     * Get the ratings linked to this advert
     *
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {

        return $this->ratings;

    }

    /**
     * Add a rating linked to this advert
     *
     * @param Rating $rating
     * @return self
     */
    public function addRating(Rating $rating): self
    {

        if (!$this->ratings->contains($rating)) 
        {

            $this->ratings[] = $rating;
            $rating->setAdvert($this);

        }

        return $this;

    }

    /**
     * Remove a rating linked to this advert
     *
     * @param Rating $rating
     * @return self
     */
    public function removeRating(Rating $rating): self
    {

        if ($this->ratings->contains($rating)) 
        {

            $this->ratings->removeElement($rating);

            // set the owning side to null (unless already changed)
            if ($rating->getAdvert() === $this) 
            {

                $rating->setAdvert(null);

            }

        }

        return $this;
        
    }
    
}
