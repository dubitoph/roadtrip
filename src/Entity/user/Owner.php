<?php

namespace App\Entity\user;

use App\Entity\user\User;
use App\Entity\advert\Advert;
use App\Entity\address\Address;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\communication\Thread;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\user\OwnerRepository")
 * 
 * @UniqueEntity(fields="user", message="This user is already linked to an other owner.")
 */
class Owner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $companyNumber;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\address\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $billingAddress;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\user\User", inversedBy="owner", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Advert", mappedBy="owner")
     */
    private $adverts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Thread", mappedBy="owner", orphanRemoval=true)
     * @OrderBy({"createdAt" = "DESC"})
     */
    private $threads;

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->adverts = new ArrayCollection();
        $this->threads = new ArrayCollection(); 

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
     * Get the company name
     *
     * @return string|null
     */
    public function getCompanyName(): ?string
    {

        return $this->companyName;

    }

    /**
     * Set the company name
     *
     * @param string $companyName
     * @return self
     */
    public function setCompanyName(string $companyName): self
    {

        $this->companyName = $companyName;

        return $this;

    }

    /**
     * Get the company number
     *
     * @return string|null
     */
    public function getCompanyNumber(): ?string
    {

        return $this->companyNumber;

    }

    /**
     * Set the company number
     *
     * @param string $companyNumber
     * @return self
     */
    public function setCompanyNumber(string $companyNumber): self
    {

        $this->companyNumber = $companyNumber;

        return $this;

    } 

    /**
     * Get the billing address
     *
     * @return Address|null
     */
    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    /**
     * Set the billing address
     *
     * @param Address $billingAddress
     * @return self
     */
    public function setBillingAddress(Address $billingAddress): self
    {

        $this->billingAddress = $billingAddress;

        return $this;

    }

    /**
     * Get the user
     *
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * Set the user
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get adverts
     *
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {

        return $this->adverts;

    }

    /**
     * Add an advert
     *
     * @param Advert $advert
     * @return self
     */
    public function addAdvert(Advert $advert): self
    {
        
        if (!$this->adverts->contains($advert)) 
        {

            $this->adverts[] = $advert;
            $advert->setOwner($this);

        }

        return $this;

    }

    /**
     * Remove an advert
     *
     * @param Advert $advert
     * @return self
     */
    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) 
        {

            $this->adverts->removeElement($advert);

            // set the owning side to null (unless already changed)
            if ($advert->getOwner() === $this) 
            {

                $advert->setOwner(null);

            }

        }

        return $this;

    }

    /**
     * Get threads
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
    
}
