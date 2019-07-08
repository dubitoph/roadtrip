<?php

namespace App\Entity\advert;

use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\InsuranceRepository")
 */
class Insurance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\LessThan(
     *     value = 2500,
     *     message = "La franchise doit être inférieure à 2500 €."
     * )
     */
    private $deductible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $included;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\advert\Advert", mappedBy="insurance")
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\InsurancePrice", mappedBy="insurance", orphanRemoval=true, cascade={"persist"})
     */
    private $insurancePrices;

    public function __construct()
    {
        $this->insurancePrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeductible(): ?int
    {
        return $this->deductible;
    }

    public function setDeductible(int $deductible): self
    {
        $this->deductible = $deductible;

        return $this;
    }

    public function getIncluded(): ?bool
    {
        return $this->included;
    }

    public function setIncluded(bool $included): self
    {
        $this->included = $included;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * @return Collection|InsurancePrice[]
     */
    public function getInsurancePrices(): Collection
    {
        return $this->insurancePrices;
    }

    public function addInsurancePrice(InsurancePrice $insurancePrice): self
    {
        if (!$this->insurancePrices->contains($insurancePrice)) {
            $this->insurancePrices[] = $insurancePrice;
            $insurancePrice->setInsurance($this);
        }

        return $this;
    }

    public function removeInsurancePrice(InsurancePrice $insurancePrice): self
    {
        if ($this->insurancePrices->contains($insurancePrice)) {
            $this->insurancePrices->removeElement($insurancePrice);
            // set the owning side to null (unless already changed)
            if ($insurancePrice->getInsurance() === $this) {
                $insurancePrice->setInsurance(null);
            }
        }

        return $this;
    }
}
