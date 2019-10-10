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
     *      message = "The duration can't be empty."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "The duration must at least contain {{limit}} characters.",
     *      maxMessage = "The duration can not exceed {{limit}} characters."
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 1,
     *     message = "The days number must be greater or equal than {value}."
     * )
     * @Assert\LessThan(
     *     value = 32,
     *     message = "The days number must be less or equal than {value}."
     * )
     */
    private $daysNumber;

    /**
     * Get a string representing the equipment
     *
     * @return string
     */
    public function __toString()
    {

        return $this->duration;

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
     * Get the duration
     *
     * @return string|null
     */
    public function getDuration(): ?string
    {

        return $this->duration;

    }

    /**
     * Set the duration
     *
     * @param string $duration
     * 
     * @return self
     */
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
     * 
     * @return self
     */
    public function setDaysNumber(int $daysNumber): self
    {

        $this->daysNumber = $daysNumber;

        return $this;

    }
    
}
