<?php

namespace App\Entity\user;

use App\Entity\user\User;
use App\Entity\advert\Advert;
use App\Entity\address\Address;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\user\OwnerRepository")
 * 
 * @UniqueEntity(fields="user", message="L'utilisateur est déjà lié à un autre propriétaire.")
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

    public function __construct()
    {

        $this->adverts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyNumber(): ?string
    {
        return $this->companyNumber;
    }

    public function setCompanyNumber(string $companyNumber): self
    {
        $this->companyNumber = $companyNumber;

        return $this;
    } 

    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(Address $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $advert->setOwner($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getOwner() === $this) {
                $advert->setOwner(null);
            }
        }

        return $this;
    }
    
}
