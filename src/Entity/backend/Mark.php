<?php

namespace App\Entity\backend;

use Cocur\Slugify\Slugify;
use App\Entity\advert\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\MarkRepository")
 * 
 * @UniqueEntity(
 *     fields={"mark"},
 *     message="La marque encodée existe déjà"
 * )
 */
class Mark
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(
     *      message = "La marque ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "La marque doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La marque ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $mark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="mark")
     */
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {

        return $this->vehicles;

    }

    public function addVehicle(Vehicle $vehicle): self
    {

        if (!$this->vehicles->contains($vehicle)) 
        {

            $this->vehicles[] = $vehicle;
            $vehicle->setMark($this);

        }

        return $this;

    }

    public function removeVehicle(Vehicle $vehicle): self
    {

        if ($this->vehicles->contains($vehicle)) 
        {

            $this->vehicles->removeElement($vehicle);

            // set the owning side to null (unless already changed)
            if ($vehicle->getMark() === $this) 
            {

                $vehicle->setMark(null);

            }

        }

        return $this;
        
    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->mark);

    }
}
