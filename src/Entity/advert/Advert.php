<?php

namespace App\Entity\advert;

use App\Entity\user\Favorite;
use App\Entity\user\Owner;
use Cocur\Slugify\Slugify;
use App\Entity\advert\Photo;
use App\Entity\advert\Price;
use App\Entity\backend\Bill;
use App\Entity\advert\Period;
use App\Entity\rating\Rating;
use App\Entity\advert\Vehicle;
use App\Entity\advert\Insurance;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\communication\Mail;
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
 *               fields={"title"},
 *               message="Une annonce avec ce titre existe déjà. Veuillez donc en créer un autre."
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
     *      minMessage = "Le titre doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Assert\Length(
     *      min = 20,
     *      max = 5000,
     *      minMessage = "La description doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La description ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Photo", mappedBy="advert", orphanRemoval=true, cascade={"persist"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="advert")
     */
    private $mails;

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
    private $stripeIntentId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\backend\Bill", mappedBy="advert")
     */
    private $bills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="advert", orphanRemoval=true)
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\user\Favorite", mappedBy="advert", orphanRemoval=true)
     */
    private $favorites;

    public function __construct() 
	{
        $this->createdAt = new \DateTime();
        $this->photos = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->periods = new ArrayCollection();
        $this->includedMileages = new ArrayCollection();
        $this->mails = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

	public function setExpiresAt(?\DateTimeInterface $expiresAt): self
                                                                                        {
                                                                                            $this->expiresAt = $expiresAt;
                                                                                                                                                                                                         
                                                                                            return $this;
                                                                                        }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle = null): self
    {
        $this->vehicle = $vehicle;
        $this->vehicle->setAdvert($this);

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function setPhotos(Collection $photos)
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
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {

        return $this->prices;
        
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setAdvert($this);
        }

        return $this;
    }

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
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period)) 
        {

            $this->periods[] = $period;
            $period->setAdvert($this);

        }

        return $this;

    }

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

    public function getInsurance(): ?Insurance
    {
        return $this->insurance;
    }

    public function setInsurance(Insurance $insurance): self
    {
        $this->insurance = $insurance;

        // set the owning side of the relation if necessary
        if ($this !== $insurance->getAdvert()) {
            $insurance->setAdvert($this);
        }

        return $this;
    }

    public function getExtraKilometerCost(): ?float
    {
        return $this->extraKilometerCost;
    }

    public function setExtraKilometerCost(?float $extraKilometerCost): self
    {
        $this->extraKilometerCost = $extraKilometerCost;

        return $this;
    }

    /**
     * @return Collection|IncludedMileage[]
     */
    public function getIncludedMileages(): Collection
    {
        return $this->includedMileages;
    }

    public function addIncludedMileage(IncludedMileage $includedMileage): self
    {
        if (!$this->includedMileages->contains($includedMileage)) 
        {

            $this->includedMileages[] = $includedMileage;
            $includedMileage->setAdvert($this);

        }

        return $this;

    }

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

    public function getIncludedCleaning(): ?bool
    {
        return $this->includedCleaning;
    }

    public function setIncludedCleaning(bool $includedCleaning): self
    {
        $this->includedCleaning = $includedCleaning;

        return $this;
    }

    public function getCleaningCost(): ?int
    {
        return $this->cleaningCost;
    }

    public function setCleaningCost(?int $cleaningCost): self
    {
        $this->cleaningCost = $cleaningCost;

        return $this;
    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->title);

    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

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
            $mail->setAdvert($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): self
    {
        if ($this->mails->contains($mail)) {
            $this->mails->removeElement($mail);
            // set the owning side to null (unless already changed)
            if ($mail->getAdvert() === $this) {
                $mail->setAdvert(null);
            }
        }

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getStripeIntentId(): ?string
    {
        return $this->stripeIntentId;
    }

    public function setStripeIntentId(?string $stripeIntentId): self
    {
        $this->stripeIntentId = $stripeIntentId;

        return $this;
    }

    /**
     * @return Collection|Bill[]
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills[] = $bill;
            $bill->setOwner($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->contains($bill)) {
            $this->bills->removeElement($bill);
            // set the owning side to null (unless already changed)
            if ($bill->getOwner() === $this) {
                $bill->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setAdvert($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getAdvert() === $this) {
                $rating->setAdvert(null);
            }
        }

        return $this;
    }

    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setAdvert($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->contains($favorite)) {
            $this->favorites->removeElement($favorite);
            // set the owning side to null (unless already changed)
            if ($favorite->getAdvert() === $this) {
                $favorite->setAdvert(null);
            }
        }

        return $this;
    }
    
}
