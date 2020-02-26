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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DistributionBoxRepository")
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields={"name"},
 *     message="El nombre de la caja ya ha sido usado."
 * )
 */
class DistributionBox implements EntityIconable
{
    /**
     * @var int Number of ports
     * @todo Change this for dynamic database entity
     */
    public const PORTS = 24;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","distribution-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Groups({"distribution-box","path"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nodo", inversedBy="distributionBox")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nodo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBoxSignal", mappedBy="distributionBox", orphanRemoval=true)
     */
    private $distributionBoxSignals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBox", mappedBy="distributionBox", cascade={"persist","remove"})
     * @Groups({"map"})
     */
    private $subscriberBoxes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="distributionBoxes", cascade={"persist"})
     * @Groups({"distribution-box","path"})
     */
    private $address;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBoxPdf", mappedBy="distributionBox", cascade={"persist","remove"})
     * @Assert\Valid
     * @Groups({"distribution-box"})
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBoxImage", mappedBy="distributionBox", cascade={"persist","remove"})
     * @Assert\Valid
     * @Groups({"distribution-box"})
     */
    private $images;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\LayerGroup", inversedBy="distributionBoxes")
     */
    private $layerGroup;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"map","path"})
     */
    private $icon;
    
    /**
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
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBoxPort", mappedBy="distributionBox", orphanRemoval=true, cascade={"persist"})
     * @Groups({"distribution-box"})
     */
    private $ports;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBoxPassant", mappedBy="distributionBox", orphanRemoval=true, cascade={"persist"})
     * @Groups({"distribution-box"})
     * @Assert\Valid
     */
    private $passants;

    
    public function __construct()
    {
        $this->distributionBoxSignals = new ArrayCollection();
        $this->subscriberBoxes = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->ports = new ArrayCollection();
        $this->passants = new ArrayCollection();
        $this->updatedAt = new \DateTime();
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

    public function getNodo(): ?Nodo
    {
        return $this->nodo;
    }

    public function setNodo(?Nodo $nodo): self
    {
        $this->nodo = $nodo;

        return $this;
    }

    /**
     * @return Collection|DistributionBoxSignal[]
     */
    public function getDistributionBoxSignals(): Collection
    {
        return $this->distributionBoxSignals;
    }

    public function addDistributionBoxSignal(DistributionBoxSignal $distributionBoxSignal): self
    {
        if (!$this->distributionBoxSignals->contains($distributionBoxSignal)) {
            $this->distributionBoxSignals[] = $distributionBoxSignal;
            $distributionBoxSignal->setDistributionBox($this);
        }

        return $this;
    }

    public function removeDistributionBoxSignal(DistributionBoxSignal $distributionBoxSignal): self
    {
        if ($this->distributionBoxSignals->contains($distributionBoxSignal)) {
            $this->distributionBoxSignals->removeElement($distributionBoxSignal);
            // set the owning side to null (unless already changed)
            if ($distributionBoxSignal->getDistributionBox() === $this) {
                $distributionBoxSignal->setDistributionBox(null);
            }
        }

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
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|SubscriberBox[]
     */
    public function getSubscriberBoxes(): Collection
    {
        return $this->subscriberBoxes;
    }

    public function addSubscriberBox(SubscriberBox $subscriberBox): self
    {
        if (!$this->subscriberBoxes->contains($subscriberBox)) {
            $this->subscriberBoxes[] = $subscriberBox;
            $subscriberBox->setDistributionBox($this);
        }

        return $this;
    }

    public function removeSubscriberBox(SubscriberBox $subscriberBox): self
    {
        if ($this->subscriberBoxes->contains($subscriberBox)) {
            $this->subscriberBoxes->removeElement($subscriberBox);
            // set the owning side to null (unless already changed)
            if ($subscriberBox->getDistributionBox() === $this) {
                $subscriberBox->setDistributionBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DistributionBoxPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(DistributionBoxPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setDistributionBox($this);
        }

        return $this;
    }

    public function removePdf(DistributionBoxPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getDistributionBox() === $this) {
                $pdf->setDistributionBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DistributionBoxImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(DistributionBoxImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setDistributionBox($this);
        }

        return $this;
    }

    public function removeImage(DistributionBoxImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getDistributionBox() === $this) {
                $image->setDistributionBox(null);
            }
        }

        return $this;
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
     * @return Collection|DistributionBoxPort[]
     */
    public function getPorts(): Collection
    {
        return $this->ports;
    }

    public function addPort(DistributionBoxPort $port): self
    {
        if (!$this->ports->contains($port)) {
            $this->ports[] = $port;
            $port->setDistributionBox($this);
        }

        return $this;
    }

    public function removePort(DistributionBoxPort $port): self
    {
        if ($this->ports->contains($port)) {
            $this->ports->removeElement($port);
            // set the owning side to null (unless already changed)
            if ($port->getDistributionBox() === $this) {
                $port->setDistributionBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DistributionBoxPassant[]
     */
    public function getPassants(): Collection
    {
        return $this->passants;
    }

    public function addPassant(DistributionBoxPassant $passant): self
    {
        if (!$this->passants->contains($passant)) {
            $this->passants[] = $passant;
            $passant->setDistributionBox($this);
        }

        return $this;
    }

    public function removePassant(DistributionBoxPassant $passant): self
    {
        if ($this->passants->contains($passant)) {
            $this->passants->removeElement($passant);
            // set the owning side to null (unless already changed)
            if ($passant->getDistributionBox() === $this) {
                $passant->setDistributionBox(null);
            }
        }

        return $this;
    }
    
    public function isFiberInUse(Fiber $fiber) {
        foreach ($this->passants as $dsBoxPassant) {
            if ($dsBoxPassant->existFiber($fiber)) {
                return true;
            }
        }
        
        return false;
    }

}
