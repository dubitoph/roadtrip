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
 * @ORM\Entity(repositoryClass="App\Repository\backend\SortRepository")
 * @UniqueEntity(
 *     fields={"sort"},
 *     message="La sorte encodée existe déjà"
 * )
 */
class Sort
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
     *      message = "La sorte ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "La sorte doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La sorte ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $sort;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\advert\Vehicle", mappedBy="sort")
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

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(string $sort): self
    {
        $this->sort = $sort;

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
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setSort($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getSort() === $this) {
                $vehicle->setSort(null);
            }
        }

        return $this;
    }

    public function getSlug(): string 
    {

        return $slugify = (new Slugify())->slugify($this->sort);

    }
}
