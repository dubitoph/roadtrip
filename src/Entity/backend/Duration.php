<?php

namespace App\Entity\backend;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\DurationRepository")
 */
class Duration
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
     * @Assert\NotBlank(
     *      message = "La durée ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "La durée doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "La durée ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\GreaterThan(
     *     value = 1,
     *     message = "Le nombre de jours doit être supérieur à 2."
     * )
     * @Assert\LessThan(
     *     value = 32,
     *     message = "Le nombre de jours doit être inférieur à 31."
     * )
     */
    private $daysNumber;

    public function __toString(){

        return $this->duration;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get days number
     *
     * @return integer
     */
    public function getDaysNumber(): ?int
    {
        return $this->daysNumber;
    }

    /**
     * Set days number
     *
     * @param integer $daysNumber
     * @return self
     */
    public function setDaysNumber(int $daysNumber): self
    {
        $this->daysNumber = $daysNumber;

        return $this;
    }
}
