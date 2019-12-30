<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WireRepository")
 * @Vich\Uploadable
 * @UniqueEntity("name")
 */
class Wire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map", "form", "torpedo", "distribution-box", "wire","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Groups({"wire", "form","torpedo","distribution-box","path"})
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     * @Groups({"map"})
     */
    private $coordinates = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"wire","distribution-box","path"})
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tube", mappedBy="wire", orphanRemoval=true)
     * @Groups({"wire"})
     */
    private $tubes;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","torpedo","distribution-box","path"})
     */
    private $hexaColor;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"map"})
     */
    private $weight;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"wire","path"})
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
     */
    private $file;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LayerGroup", inversedBy="wires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $layerGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WirePattern", inversedBy="wires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wirePattern;

    public function __construct()
    {
        $this->tubes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

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

    /**
     * @return Collection|Tube[]
     */
    public function getTubes(): Collection
    {
        return $this->tubes;
    }

    public function addTube(Tube $tube): self
    {
        if (!$this->tubes->contains($tube)) {
            $this->tubes[] = $tube;
            $tube->setWire($this);
        }

        return $this;
    }

    public function removeTube(Tube $tube): self
    {
        if ($this->tubes->contains($tube)) {
            $this->tubes->removeElement($tube);
            // set the owning side to null (unless already changed)
            if ($tube->getWire() === $this) {
                $tube->setWire(null);
            }
        }

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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLayerGroup(): ?LayerGroup
    {
        return $this->layerGroup;
    }

    public function setLayerGroup(?LayerGroup $layerGroup): self
    {
        $this->layerGroup = $layerGroup;

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }

    public function getWirePattern(): ?WirePattern
    {
        return $this->wirePattern;
    }

    public function setWirePattern(?WirePattern $wirePattern): self
    {
        $this->wirePattern = $wirePattern;

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

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    public function deleteFusionAndPasants() {
        foreach ($this->tubes as $tube) {
            $tube->deleteFusionAndPasants();
        }
    }
    
    
}
