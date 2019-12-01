<?php

namespace App\Entity\user;

use App\Entity\rating\Rating;
use App\Entity\user\Owner;
use Cocur\Slugify\Slugify;
use App\Entity\user\Profile;
use App\Entity\booking\Booking;
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
 * @UniqueEntity(fields="email", message="This email is already used.")
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
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must contain at least {{ limit }} characters.",
     *      maxMessage = "Your first name can't contain more than {{ limit }} characters."
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your name must contain at least {{ limit }} characters.",
     *      maxMessage = "Your name can't contain more than {{ limit }} characters."
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * 
     * @Assert\Length(
     *                  min = 8, 
     *                  max = 25, 
     *                  minMessage = "Your phone number must contain at least {{ limit }} characters.", 
     *                  maxMessage = "Your phone number can't contain more than {{ limit }} characters."
     *               )
     * @Assert\Regex(
     *                  pattern="/(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})/", 
     *                  message="The phone number is not in a proper format"
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
     *      minMessage = "Your email address must contain at least {{ limit }} characters.",
     *      maxMessage = "Your email address can't contain more than {{ limit }} characters."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your username must contain at least {{ limit }} characters.",
     *      maxMessage = "Your username can't contain more than {{ limit }} characters."
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
     *      minMessage = "Your password must contain at least {{ limit }} characters.",
     *      maxMessage = "Your password can't contain more than {{ limit }} characters."
     * )
     * @Assert\NotBlank()
     */
    private $password;
 
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
      * @ORM\OneToMany(targetEntity="App\Entity\booking\Booking", mappedBy="user")
      */
     private $bookings;

     /**
      * @ORM\OneToOne(targetEntity="App\Entity\user\Profile", mappedBy="user", cascade={"persist", "remove"})
      */
     private $profile;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="user")
      */
     private $createdRatings;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\rating\Rating", mappedBy="tenant")
      */
     private $receivedRatings;

     /**
      * Operations when creating
      */
     public function __construct()
     {

         $this->sentMails = new ArrayCollection();
         $this->receivedMails = new ArrayCollection();
         $this->favorites = new ArrayCollection();
         $this->threads = new ArrayCollection();
         $this->bookings = new ArrayCollection();
         $this->createdRatings = new ArrayCollection();
         $this->receivedRatings = new ArrayCollection();

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
     * Get firstname
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {

        return $this->firstname;

    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {

        $this->firstname = $firstname;

        return $this;

    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {

        $this->name = $name;

        return $this;

    }

    /**
     * Get phone number
     *
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {

        return $this->phoneNumber;

    }

    /**
     * Get phone number
     *
     * @param string $phoneNumber
     * @return self
     */
    public function setPhoneNumber(string $phoneNumber): self
    {

        $this->phoneNumber = $phoneNumber;

        return $this;

    }

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {

        return $this->email;

    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {

        $this->email = $email;

        return $this;

    }

    /**
     * Get username
     * 
     * @see UserInterface
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {

        return $this->username;

    }

    /**
     * Set username
     * 
     * @see UserInterface
     *
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): self
    {

        $this->username = $username;

        return $this;

    }

    /**
     * Get roles
     * 
     * @see UserInterface
     *
     * @return array
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

    /**
     * Set roles
     * 
     * @see UserInterface
     *
     * @param array $roles
     * @return self
     */
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
    
    /**
     * Set password
     * 
     * @see UserInterface
     *
     * @return string
     */
    public function getPassword(): string
    {

        return (string) $this->password;

    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {

        $this->password = $password;

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
     * Get the request password time
     *
     * @return void
     */
    public function getPasswordRequestedAt()
    {

        return $this->passwordRequestedAt;

    }

    /**
     * Set the request password time
     *
     * @param [type] $passwordRequestedAt
     * @return void
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {

        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;

    }

    /**
     * Get token
     *
     * @return void
     */
    public function getToken()
    {

        return $this->token;

    }

    /**
     * Set token
     *
     * @param [type] $token
     * @return void
     */
    public function setToken($token)
    {

        $this->token = $token;

        return $this;

    }

    /**
     * Get salt
     * 
     * @see UserInterface
     *
     * @return void
     */
    public function getSalt()
    {

        // Not needed when using the "bcrypt" algorithm in security.yaml

    }

    /**
     * Set salt
     * 
     * @see UserInterface
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // When storing any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Serialize id, username, email and password
     *
     * @return void
     */
    public function serialize()
    {

        return serialize(
                            [
                                $this->id,
                                $this->username,
                                $this->email,
                                $this->password
                            ]
                        )
        ;

    }

    /**
     * Unserialize id, username, email and password
     *
     * @param [type] $serialized
     * @return void
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

    /**
     * Get the ownner linked to the user
     *
     * @return Owner|null
     */
    public function getOwner(): ?Owner
    {

        return $this->owner;

    }

    /**
     * Set the ownner linked to the user
     *
     * @param Owner $owner
     * @return self
     */
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
     * Get sent emails
     *
     * @return Collection|Mail[]
     */
    public function getSentMails(): Collection
    {

        return $this->SentMails;

    }

    /**
     * Add a sent email
     *
     * @param Mail $sentMail
     * @return self
     */
    public function addSentMail(Mail $sentMail): self
    {

        if (!$this->sentMails->contains($sentMail)) 
        {

            $this->sentMails[] = $sentMail;
            $sentMail->setSender($this);

        }

        return $this;

    }

    /**
     * Remove a sent email
     *
     * @param Mail $sentMail
     * @return self
     */
    public function removeSentMail(Mail $sentMail): self
    {

        if ($this->sentMails->contains($sentMail)) 
        {

            $this->sentMails->removeElement($sentMail);

            // set the owning side to null (unless already changed)
            if ($sentMail->getSender() === $this) 
            {

                $sentMail->setSender(null);

            }
        }

        return $this;

    }

    /**
     * Get received emails
     *
     * @return Collection|Mail[]
     */
    public function getReceivedMails(): Collection
    {

        return $this->receivedMails;

    }

    /**
     * Add a received email
     *
     * @param Mail $receivedMail
     * @return self
     */
    public function addReceivedMail(Mail $receivedMail): self
    {

        if (!$this->receivedMails->contains($receivedMail)) 
        {

            $this->receivedMails[] = $receivedMail;
            $receivedMail->setReceiver($this);

        }

        return $this;

    }

    /**
     * Remove a received email
     *
     * @param Mail $receivedMail
     * @return self
     */
    public function removeReceivedMail(Mail $receivedMail): self
    {

        if ($this->receivedMails->contains($receivedMail)) 
        {

            $this->receivedMails->removeElement($receivedMail);

            // set the owning side to null (unless already changed)
            if ($receivedMail->getReceiver() === $this) 
            {

                $receivedMail->setReceiver(null);

            }

        }

        return $this;

    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->username);

    }

    /**
     * Get favorite adverts
     *
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {

        return $this->favorites;

    }

    /**
     * Add a favorite advert
     *
     * @param Favorite $favorite
     * @return self
     */
    public function addFavorite(Favorite $favorite): self
    {

        if (!$this->favorites->contains($favorite)) 
        {

            $this->favorites[] = $favorite;
            $favorite->setUser($this);

        }

        return $this;

    }

    /**
     * Remove a favorite advert
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
            if ($favorite->getUser() === $this) 
            {

                $favorite->setUser(null);

            }

        }

        return $this;

    }

    /**
     * Set threads
     *
     * @return Collection|Thread[]
     */
    public function getThreads(): Collection
    {

        return $this->threads;

    }

    /**
     * Add a thread
     *
     * @param Thread $thread
     * @return self
     */
    public function addThread(Thread $thread): self
    {

        if (!$this->threads->contains($thread)) 
        {

            $this->threads[] = $thread;
            $thread->setCreator($this);

        }

        return $this;

    }

    /**
     * Remove a thread
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
            if ($thread->getCreator() === $this) 
            {

                $thread->setCreator(null);

            }
        }

        return $this;

    }

    /**
     * Set bookings
     *
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {

        return $this->bookings;

    }

    /**
     * Add a booking
     *
     * @param Booking $booking
     * @return self
     */
    public function addBooking(Booking $booking): self
    {

        if (!$this->bookings->contains($booking)) 
        {

            $this->bookings[] = $booking;
            $booking->setUser($this);

        }

        return $this;

    }

    /**
     * Remove a booking
     *
     * @param Booking $booking
     * @return self
     */
    public function removeBooking(Booking $booking): self
    {

        if ($this->bookings->contains($booking)) 
        {

            $this->bookings->removeElement($booking);

            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) 
            {

                $booking->setUser(null);

            }

        }

        return $this;

    }

    /**
     * Get the profile
     *
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {

        return $this->profile;

    }

    /**
     * Set the profile
     *
     * @param Profile $profile
     * @return self
     */
    public function setProfile(Profile $profile): self
    {

        $this->profile = $profile;


        // set the owning side of the relation if necessary
        if ($this !== $profile->getUser()) 
        {

            $profile->setUser($this);

        }

        return $this;

    }

    /**
     * Get ratings created by the user
     *
     * @return Collection|Rating[]
     */
    public function getCreatedRatings(): Collection
    {

        return $this->ratings;

    }

    /**
     * Add a rating created by the user
     *
     * @param Rating $createdRating
     * @return self
     */
    public function addCreatedRating(Rating $createdRating): self
    {

        if (!$this->createdRatings->contains($createdRating)) 
        {

            $this->createdRatings[] = $createdRating;
            $createdRating->setUser($this);

        }

        return $this;

    }

    /**
     * Remove a rating created by the user
     *
     * @param Rating $createdRating
     * @return self
     */
    public function removeCreatedRating(Rating $createdRating): self
    {

        if ($this->createdRatings->contains($createdRating)) 
        {

            $this->createdRatings->removeElement($createdRating);

            // set the owning side to null (unless already changed)
            if ($createdRating->getUser() === $this) 
            {

                $createdRating->setUser(null);

            }

        }

        return $this;

    }

    /**
     * Get ratings received by the user
     *
     * @return Collection|Rating[]
     */
    public function getReceivedRatings(): Collection
    {

        return $this->receivedRatings;

    }

    /**
     * Add a rating received by the user
     *
     * @param Rating $receivedRating
     * @return self
     */
    public function addReceivedRating(Rating $receivedRating): self
    {

        if (!$this->receivedRatings->contains($receivedRating)) 
        {

            $this->receivedRatings[] = $receivedRating;
            $receivedRating->setTenant($this);

        }

        return $this;

    }

    /**
     * Remove a rating received by the user
     *
     * @param Rating $receivedRating
     * @return self
     */
    public function removeReceivedRating(Rating $receivedRating): self
    {

        if ($this->receivedRatings->contains($receivedRating)) 
        {

            $this->receivedRatings->removeElement($receivedRating);

            // set the owning side to null (unless already changed)
            if ($receivedRating->getTenant() === $this) 
            {

                $receivedRating->setTenant(null);

            }

        }

        return $this;
        
    }
    
}
