<?php

namespace App\Entity\advert;

use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\advert\PhotoRepository")
 * @Vich\Uploadable()
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     * )
     * @Vich\UploadableField(mapping="adverts_photos", fileNameProperty="name")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="App\Entity\advert\Advert")
     * @Assert\Valid()
     */
    private $advert;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mainPhoto;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {        
        $this->created_at = new \DateTime();        
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Photo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(Advert $advert = null): self
    {
		$this->advert = $advert;

        return $this;
	}    

    /**
     * @return null|File
     */
    public function getFile(): ?File
    {
        return $this->file;
    }
	
    /**
     * @param null|File $file
     * @return self
     */public function setFile(?File $file = null): self
    {
        $this->file = $file;

        if ($this->file instanceof UploadedFile) 
        {

            $this->updated_at = new \DateTime('now');

        }

        return $this;
    }

    public function getMainPhoto(): ?bool
    {
        return $this->mainPhoto;
    }

    public function setMainPhoto(?bool $mainPhoto): self
    {
        $this->mainPhoto = $mainPhoto;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
