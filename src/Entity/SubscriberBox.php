<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Interfaces\EntityIconable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberBoxRepository")
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields={"name"},
 *     message="El nombre de la caja ya ha sido usado."
 * )
 */
class SubscriberBox implements EntityIconable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","subscriber-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Groups({"subscriber-box"})
     */
    private $name;

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
     * @Groups({"subscriber-box"})
     */
    private $tubeColor;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"map"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxSignal", mappedBy="subscriberBox", orphanRemoval=true)
     */
    private $subscriberBoxSignals;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DistributionBox", inversedBy="subscriberBoxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distributionBox;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxPdf", mappedBy="subscriberBox", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     * @Groups({"subscriber-box"})
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxImage", mappedBy="subscriberBox", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     * @Groups({"subscriber-box"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="subscriberBoxes", cascade={"persist"})
     * @Groups({"subscriber-box"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxExt", mappedBy="subscriberBox")
     * @Groups({"map"})
     */
    private $subscriberBoxExts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxCustomer", mappedBy="subscriberBox", orphanRemoval=true, cascade={"persist","remove"})
     * @Assert\Valid
     * @Groups({"subscriber-box"})
     */
    private $customers;


    public function __construct()
    {
        $this->subscriberBoxSignals = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->subscriberBoxExts = new ArrayCollection();
        $this->customers = new ArrayCollection();
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

    /**
     * @return Collection|SubscriberBoxSignal[]
     */
    public function getSubscriberBoxSignals(): Collection
    {
        return $this->subscriberBoxSignals;
    }

    public function addSubscriberBoxSignal(SubscriberBoxSignal $subscriberBoxSignal): self
    {
        if (!$this->subscriberBoxSignals->contains($subscriberBoxSignal)) {
            $this->subscriberBoxSignals[] = $subscriberBoxSignal;
            $subscriberBoxSignal->setSubscriberBox($this);
        }

        return $this;
    }

    public function removeSubscriberBoxSignal(SubscriberBoxSignal $subscriberBoxSignal): self
    {
        if ($this->subscriberBoxSignals->contains($subscriberBoxSignal)) {
            $this->subscriberBoxSignals->removeElement($subscriberBoxSignal);
            // set the owning side to null (unless already changed)
            if ($subscriberBoxSignal->getSubscriberBox() === $this) {
                $subscriberBoxSignal->setSubscriberBox(null);
            }
        }

        return $this;
    }

    public function getDistributionBox(): ?DistributionBox
    {
        return $this->distributionBox;
    }

    public function setDistributionBox(?DistributionBox $distributionBox): self
    {
        $this->distributionBox = $distributionBox;

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|SubscriberBoxPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(SubscriberBoxPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setSubscriberBox($this);
        }

        return $this;
    }

    public function removePdf(SubscriberBoxPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getSubscriberBox() === $this) {
                $pdf->setSubscriberBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SubscriberBoxImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(SubscriberBoxImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setSubscriberBox($this);
        }

        return $this;
    }

    public function removeImage(SubscriberBoxImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getSubscriberBox() === $this) {
                $image->setSubscriberBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SubscriberBoxExt[]
     */
    public function getSubscriberBoxExts(): Collection
    {
        return $this->subscriberBoxExts;
    }

    public function addSubscriberBoxExt(SubscriberBoxExt $subscriberBoxExt): self
    {
        if (!$this->subscriberBoxExts->contains($subscriberBoxExt)) {
            $this->subscriberBoxExts[] = $subscriberBoxExt;
            $subscriberBoxExt->setSubscriberBox($this);
        }

        return $this;
    }

    public function removeSubscriberBoxExt(SubscriberBoxExt $subscriberBoxExt): self
    {
        if ($this->subscriberBoxExts->contains($subscriberBoxExt)) {
            $this->subscriberBoxExts->removeElement($subscriberBoxExt);
            // set the owning side to null (unless already changed)
            if ($subscriberBoxExt->getSubscriberBox() === $this) {
                $subscriberBoxExt->setSubscriberBox(null);
            }
        }

        return $this;
    }

    public function getTubeColor(): ?string
    {
        return $this->tubeColor;
    }

    public function setTubeColor(?string $tubeColor): self
    {
        $this->tubeColor = $tubeColor;

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
     * @return Collection|SubscriberBoxCustomer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(SubscriberBoxCustomer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setSubscriberBox($this);
        }

        return $this;
    }

    public function removeCustomer(SubscriberBoxCustomer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getSubscriberBox() === $this) {
                $customer->setSubscriberBox(null);
            }
        }

        return $this;
    }

}
