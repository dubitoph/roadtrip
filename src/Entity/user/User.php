<?php

namespace App\Entity\user;

use App\Entity\user\Profile;
use App\Entity\advert\Booking;
use App\Entity\user\Owner;
use Cocur\Slugify\Slugify;
use App\Entity\rating\Rating;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\communication\Mail;
use App\Entity\communication\Thread;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\user\UserRepository")
 * 
 * @UniqueEntity(fields="email", message="Cet email est déjà utilisé.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre prénom doit contenir minimum 2 caractères",
     *      maxMessage = "Votre prénom ne peut dépasser {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom doit contenir minimum 2 caractères",
     *      maxMessage = "Votre nom ne peut dépasser {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * 
     * @Assert\Length(
     *                  min = 8, 
     *                  max = 25, 
     *                  minMessage = "Votre numéro de téléphone doit contenir minimum 8 caractères", 
     *                  maxMessage = "Votre numéro de téléphone doit contenir maximum 25 caractères"
     *               )
     * @Assert\Regex(
     *                  pattern="/(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})/", 
     *                  message="Votre numéro de téléphone n'est pas dans un format adéquat"
     *              )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     * @Assert\Email()
     * @Assert\NotBlank() 
     * @Assert\Length(
     *      min = 7,
     *      max = 180,
     *      minMessage = "Votre adresse email doit contenir minimum 7 caractères",
     *      maxMessage = "Votre adresse email ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom d'utilisateur doit contenir minimum 2 caractères",
     *      maxMessage = "Votre nom d'utilisateur ne peut dépasser {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     */
     private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * 
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Votre mot de passe doit contenir minimum 8 caractères",
     *      maxMessage = "Votre mot de passe ne peut dépasser {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     */
    private $password;  

    public $confirmedPassword;
 
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $passwordRequestedAt;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $token;

     /**
      * @ORM\OneToOne(targetEntity="App\Entity\user\Owner", mappedBy="user", cascade={"persist", "remove"})
      */
     private $owner;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="sender")
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $sentMails;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="receiver")
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $receivedMails;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="user")
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $sentRatings;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="tenant")
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $receivedRatings;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\user\Favorite", mappedBy="user", orphanRemoval=true)
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $favorites;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\communication\Thread", mappedBy="user", orphanRemoval=true)
      * @OrderBy({"createdAt" = "DESC"})
      */
     private $threads;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\advert\Booking", mappedBy="user")
      */
     private $bookings;

     /**
      * @ORM\OneToOne(targetEntity="App\Entity\user\Profile", mappedBy="user", cascade={"persist", "remove"})
      */
     private $profile;

     public function __construct()
     {
         $this->sentMails = new ArrayCollection();
         $this->receivedMails = new ArrayCollection();
         $this->sentRatings = new ArrayCollection();
         $this->receivedRatings = new ArrayCollection();
         $this->favorites = new ArrayCollection();
         $this->threads = new ArrayCollection();
         $this->bookings = new ArrayCollection(); 
     }

    public function getId(): ?int
    {
        return $this->id;
    }  
    
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        
        $roles = $this->roles;
    
        if (empty($roles)) 
        {

            $roles[] = 'ROLE_USER';

        }
    
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {

        if (!in_array('ROLE_USER', $roles))
        {

            $roles[] = 'ROLE_USER';

        }

        foreach ($roles as $role)
        {

            if(substr($role, 0, 5) !== 'ROLE_') 
            {

                throw new InvalidArgumentException("Chaque rôle doit commencer par 'ROLE_'");

            }

        }

        $this->roles = $roles;

        return $this;
        
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmedPassword(): string
    {
        return (string) $this->confirmedPassword;
    }

    public function setConfirmedPassword(string $confirmedPassword): self
    {
        $this->confirmedPassword = $confirmedPassword;

        return $this;
    }
 
    /*
     * Get isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
 
    /*
     * Set isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /*
     * Get passwordRequestedAt
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /*
     * Set passwordRequestedAt
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /*
     * Get token
     */
    public function getToken()
    {
        return $this->token;
    }

    /*
     * Set token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     * @since 5.1.0
     */
    public function serialize()
    {

        return serialize([
                          $this->id,
                          $this->username,
                          $this->email,
                          $this->password
                         ]
                        )
        ;

    }

    /**
     * @param string $serialized 
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {

        list(
             $this->id,
             $this->username,
             $this->email,
             $this->password
            )
        = unserialize($serialized, ['allowed_class' => false]);

    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        // set the owning side of the relation if necessary
        if ($this !== $owner->getUser()) 
        {

            $owner->setUser($this);
            
        }

        return $this;
    }

    /**
     * @return Collection|Mail[]
     */
    public function getSentMails(): Collection
    {
        return $this->SentMails;
    }

    public function addSentMail(Mail $sentMail): self
    {
        if (!$this->sentMails->contains($sentMail)) {
            $this->sentMails[] = $sentMail;
            $sentMail->setSender($this);
        }

        return $this;
    }

    public function removeSentMail(Mail $sentMail): self
    {
        if ($this->sentMails->contains($sentMail)) {
            $this->sentMails->removeElement($sentMail);
            // set the owning side to null (unless already changed)
            if ($sentMail->getSender() === $this) {
                $sentMail->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mail[]
     */
    public function getReceivedMails(): Collection
    {
        return $this->receivedMails;
    }

    public function addReceivedMail(Mail $receivedMail): self
    {
        if (!$this->receivedMails->contains($receivedMail)) {
            $this->receivedMails[] = $receivedMail;
            $receivedMail->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMail(Mail $receivedMail): self
    {
        if ($this->receivedMails->contains($receivedMail)) {
            $this->receivedMails->removeElement($receivedMail);
            // set the owning side to null (unless already changed)
            if ($receivedMail->getReceiver() === $this) {
                $receivedMail->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getSentRatings(): Collection
    {
        return $this->sentRatings;
    }

    public function addSentRating(Rating $sentRating): self
    {
        if (!$this->sentRatings->contains($sentRating)) {
            $this->sentRatings[] = $sentRating;
            $sentRating->setUser($this);
        }

        return $this;
    }

    public function removeSentRating(Rating $sentRating): self
    {
        if ($this->sentRatings->contains($sentRating)) {
            $this->sentRatings->removeElement($sentRating);
            // set the owning side to null (unless already changed)
            if ($sentRating->getUser() === $this) {
                $sentRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getReceivedRatings(): Collection
    {
        return $this->receivedratings;
    }

    public function addReceivedRating(Rating $receivedRating): self
    {
        if (!$this->receivedRatings->contains($receivedRating)) {
            $this->receivedRatings[] = $receivedRating;
            $receivedRating->setTenant($this);
        }

        return $this;
    }

    public function removeReceivedRating(Rating $receivedRating): self
    {

        if ($this->receivedRatings->contains($receivedRating)) {
            $this->receivedRatings->removeElement($receivedRating);
            // set the owning side to null (unless already changed)
            if ($receivedRating->getTenant() === $this) {
                $receivedRating->setTenant(null);
            }
        }

        return $this;

    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->username);

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
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->contains($favorite)) {
            $this->favorites->removeElement($favorite);
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Thread[]
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Thread $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads[] = $thread;
            $thread->setCreator($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): self
    {
        if ($this->threads->contains($thread)) {
            $this->threads->removeElement($thread);
            // set the owning side to null (unless already changed)
            if ($thread->getCreator() === $this) {
                $thread->setCreator(null);
            }
        }

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
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        // set the owning side of the relation if necessary
        if ($this !== $profile->getUser()) {
            $profile->setUser($this);
        }

        return $this;
    }
    
}
