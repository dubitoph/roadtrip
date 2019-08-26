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
     * @Assert\LessThanOrEqual(
     *     value = 2500,
     *     message = "The deductible must be less or equal than {{value}} €."
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

    /**
     * Operations when creating
     */
    public function __construct()
    {

        $this->insurancePrices = new ArrayCollection();

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
     * Get the deductible
     *
     * @return integer|null
     */
    public function getDeductible(): ?int
    {

        return $this->deductible;

    }

    /**
     * Set the deductible
     *
     * @param integer $deductible
     * @return self
     */
    public function setDeductible(int $deductible): self
    {

        $this->deductible = $deductible;

        return $this;

    }

    /**
     * Get if the insurance is included in the location price
     *
     * @return boolean|null
     */
    public function getIncluded(): ?bool
    {

        return $this->included;

    }

    /**
     * Set if the insurance is included in the location price
     *
     * @param boolean $included
     * @return self
     */
    public function setIncluded(bool $included): self
    {

        $this->included = $included;

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
     * @param Advert $advert
     * @return self
     */
    public function setAdvert(Advert $advert): self
    {

        $this->advert = $advert;

        return $this;

    }

    /**
     * Get insurance price for the different durations
     *
     * @return Collection|InsurancePrice[]
     */
    public function getInsurancePrices(): Collection
    {

        return $this->insurancePrices;

    }

    /**
     * Set an insurance price for a duration
     *
     * @param InsurancePrice $insurancePrice
     * @return self
     */
    public function addInsurancePrice(InsurancePrice $insurancePrice): self
    {

        if (!$this->insurancePrices->contains($insurancePrice)) 
        {

            $this->insurancePrices[] = $insurancePrice;
            $insurancePrice->setInsurance($this);

        }

        return $this;

    }

    /**
     * Remove an insurance price for a duration
     *
     * @param InsurancePrice $insurancePrice
     * @return self
     */
    public function removeInsurancePrice(InsurancePrice $insurancePrice): self
    {

        if ($this->insurancePrices->contains($insurancePrice)) 
        {

            $this->insurancePrices->removeElement($insurancePrice);

            // set the owning side to null (unless already changed)
            if ($insurancePrice->getInsurance() === $this) 
            {

                $insurancePrice->setInsurance(null);

            }

        }

        return $this;

    }
    
}
