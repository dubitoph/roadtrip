<?php

namespace App\Entity\media;

use App\Entity\user\Profile;
use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\media\PhotoRepository")
 * @Vich\Uploadable()
 */
class Photo implements \Serializable
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
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "The name must contain at least {{ limit }} characters",
     *      maxMessage = "The name can't contain more than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     * )
     * @Vich\UploadableField(mapping="photos", fileNameProperty="name")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="photos")
     * @ORM\JoinColumn(nullable=true)
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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\user\Profile", mappedBy="photo")
     */
    private $profile;

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

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        // set (or unset) the owning side of the relation if necessary
        $newPhoto = $profile === null ? null : $this;
        if ($newPhoto !== $profile->getPhoto()) {
            $profile->setPhoto($newPhoto);
        }

        return $this;
    }

    /**
     * @return string
     * @since 5.1.0
     */
    public function serialize()
    {

        return serialize([
                          $this->id,
                          $this->name
                         ]
                        )
        ;

    }

    /**
     * @param string $serialized 
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {

        list($this->id,
             $this->name
            )
        = unserialize($serialized, ['allowed_class' => false]);

    }
}
