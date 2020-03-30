<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Interfaces\EntityIconable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Note implements EntityIconable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map", "note"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"note"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"note"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"note"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $closedBy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $closed = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"note"})
     */
    private $image;
    
    /**
     * @Vich\UploadableField(mapping="images_upload", fileNameProperty="image")
     * @var File
     * @Assert\File(
     *     mimeTypes = {"image/png","image/jpeg","image/jpg","image/gif",},
     *     mimeTypesMessage = "Por favor, selecciona una imagen válida."
     * )
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"note"})
     */
    private $user;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"map"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"map"})
     */
    private $longitude;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"map"})
     */
    private $icon;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;
    
    
    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getClosedBy(): ?string
    {
        return $this->closedBy;
    }

    public function setClosedBy(?string $closedBy): self
    {
        $this->closedBy = $closedBy;

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public function __toString() {
        return $this->title;
    }
    
    public function getElapsedTime(): string {
        
        $now = new \DateTime();
        $interval = $now->diff($this->createdAt);
        return $interval->format('%a d, %h h, %i m');
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    
    public function getFile(): ?File
    {
        return $this->file;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
    
    public function getIcon(): ?string {
        return $this->icon;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    public function setIcon(?string $icon) {
        $this->icon = $icon;
    }

}
