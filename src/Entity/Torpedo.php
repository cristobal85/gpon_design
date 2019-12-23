<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Interfaces\EntityIconable;
use App\Entity\Fiber;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TorpedoRepository")
 * @Vich\Uploadable
 */
class Torpedo implements EntityIconable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","torpedo","path"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"map"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"map"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","path"})
     */
    private $icon;
    
    /**
     * 
     * @Vich\UploadableField(mapping="images_upload", fileNameProperty="icon")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\LayerGroup", inversedBy="torpedos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $layerGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TorpedoFusion", mappedBy="torpedo", orphanRemoval=true, cascade={"persist"})
     * @Groups({"torpedo"})
     * @Assert\Valid
     */
    private $torpedoFusions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="torpedos", cascade={"persist"})
     * @Groups({"torpedo","path"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TorpedoPdf", mappedBy="torpedo", orphanRemoval=true, cascade={"persist"})
     * @Groups({"torpedo"})
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TorpedoImage", mappedBy="torpedo", orphanRemoval=true, cascade={"persist"})
     * @Groups({"torpedo"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TorpedoPassant", mappedBy="torpedo", orphanRemoval=true, cascade={"persist"})
     * @Groups({"torpedo"})
     * @Assert\Valid
     */
    private $passants;
    

    public function __construct()
    {
        $this->torpedoFusions = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->updatedAt = new \DateTime();
        $this->passants = new ArrayCollection();
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    /**
     * @return Collection|TorpedoFusion[]
     */
    public function getTorpedoFusions(): Collection
    {
        return $this->torpedoFusions;
    }

    public function addTorpedoFusion(TorpedoFusion $torpedoFusion): self
    {
        if (!$this->torpedoFusions->contains($torpedoFusion)) {
            $this->torpedoFusions[] = $torpedoFusion;
            $torpedoFusion->setTorpedo($this);
        }

        return $this;
    }

    public function removeTorpedoFusion(TorpedoFusion $torpedoFusion): self
    {
        if ($this->torpedoFusions->contains($torpedoFusion)) {
            $this->torpedoFusions->removeElement($torpedoFusion);
            // set the owning side to null (unless already changed)
            if ($torpedoFusion->getTorpedo() === $this) {
                $torpedoFusion->setTorpedo(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|TorpedoPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(TorpedoPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setTorpedo($this);
        }

        return $this;
    }

    public function removePdf(TorpedoPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getTorpedo() === $this) {
                $pdf->setTorpedo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TorpedoImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(TorpedoImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTorpedo($this);
        }

        return $this;
    }

    public function removeImage(TorpedoImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getTorpedo() === $this) {
                $image->setTorpedo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TorpedoPassant[]
     */
    public function getPassants(): Collection
    {
        return $this->passants;
    }

    public function addPassant(TorpedoPassant $passant): self
    {
        if (!$this->passants->contains($passant)) {
            $this->passants[] = $passant;
            $passant->setTorpedo($this);
        }

        return $this;
    }

    public function removePassant(TorpedoPassant $passant): self
    {
        if ($this->passants->contains($passant)) {
            $this->passants->removeElement($passant);
            // set the owning side to null (unless already changed)
            if ($passant->getTorpedo() === $this) {
                $passant->setTorpedo(null);
            }
        }

        return $this;
    }
    
    public function isFiberInUse(Fiber $fiber) {
        foreach ($this->torpedoFusions as $torpedoFusion) {
            if ($torpedoFusion->existFiber($fiber)) {
                return true;
            }
        }
        
        foreach ($this->passants as $torpedoPassant) {
            if ($torpedoPassant->existFiber($fiber)) {
                return true;
            }
        }
        
        return false;
    }
}
