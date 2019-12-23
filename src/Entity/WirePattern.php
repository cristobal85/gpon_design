<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WirePatternRepository")
 * @Vich\Uploadable
 */
class WirePattern
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map", "form"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $hexaColor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TubePattern", mappedBy="wirePattern", cascade={"persist","remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $tubePatterns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FiberPattern", mappedBy="wirePattern", cascade={"persist","remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $fiberPatterns;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map", "form"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wire", mappedBy="wirePattern")
     */
    private $wires;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
    
    /**
     * @Vich\UploadableField(mapping="images_upload", fileNameProperty="image")
     * 
     * @var File
     * 
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/png","image/jpeg","image/jpg","image/gif",},
     *     mimeTypesMessage = "Por favor, selecciona una imagen válida."
     * )
     * 
     */
    private $file;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->tubePatterns = new ArrayCollection();
        $this->fiberPatterns = new ArrayCollection();
        $this->wires = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHexaColor(): ?string
    {
        return $this->hexaColor;
    }

    public function setHexaColor(string $hexaColor): self
    {
        $this->hexaColor = $hexaColor;

        return $this;
    }

    /**
     * @return Collection|TubePattern[]
     */
    public function getTubePatterns(): Collection
    {
        return $this->tubePatterns;
    }

    public function addTubePattern(TubePattern $tubePattern): self
    {
        if (!$this->tubePatterns->contains($tubePattern)) {
            $this->tubePatterns[] = $tubePattern;
            $tubePattern->setWirePattern($this);
        }

        return $this;
    }

    public function removeTubePattern(TubePattern $tubePattern): self
    {
        if ($this->tubePatterns->contains($tubePattern)) {
            $this->tubePatterns->removeElement($tubePattern);
            // set the owning side to null (unless already changed)
            if ($tubePattern->getWirePattern() === $this) {
                $tubePattern->setWirePattern(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FiberPattern[]
     */
    public function getFiberPatterns(): Collection
    {
        return $this->fiberPatterns;
    }

    public function addFiberPattern(FiberPattern $fiberPattern): self
    {
        if (!$this->fiberPatterns->contains($fiberPattern)) {
            $this->fiberPatterns[] = $fiberPattern;
            $fiberPattern->setWirePattern($this);
        }

        return $this;
    }

    public function removeFiberPattern(FiberPattern $fiberPattern): self
    {
        if ($this->fiberPatterns->contains($fiberPattern)) {
            $this->fiberPatterns->removeElement($fiberPattern);
            // set the owning side to null (unless already changed)
            if ($fiberPattern->getWirePattern() === $this) {
                $fiberPattern->setWirePattern(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Wire[]
     */
    public function getWires(): Collection
    {
        return $this->wires;
    }

    public function addWire(Wire $wire): self
    {
        if (!$this->wires->contains($wire)) {
            $this->wires[] = $wire;
            $wire->setWirePattern($this);
        }

        return $this;
    }

    public function removeWire(Wire $wire): self
    {
        if ($this->wires->contains($wire)) {
            $this->wires->removeElement($wire);
            // set the owning side to null (unless already changed)
            if ($wire->getWirePattern() === $this) {
                $wire->setWirePattern(null);
            }
        }

        return $this;
    }
    
    
    public function __toString() {
        return $this->name;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
