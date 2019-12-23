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

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberBoxExtRepository")
 * @Vich\Uploadable
 */
class SubscriberBoxExt implements EntityIconable
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
     * @Groups({"subscriber-box-ext"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscriberBox", inversedBy="subscriberBoxExts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriberBox;
    
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
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxExtPdf", mappedBy="subscriberBoxExt", orphanRemoval=true, cascade={"persist"})
     * @Groups({"subscriber-box-ext"})
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxExtImage", mappedBy="subscriberBoxExt", orphanRemoval=true, cascade={"persist"})
     * @Groups({"subscriber-box-ext"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="subscriberBoxExts", cascade={"persist"})
     * @Groups({"subscriber-box-ext"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"subscriber-box-ext"})
     */
    private $tubeColor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxCustomer", mappedBy="subscriberBoxExt", orphanRemoval=true, cascade={"persist","remove"})
     * @Assert\Valid
     * @Groups({"subscriber-box-ext"})
     */
    private $customers;

            
    public function __construct() {
        $this->updatedAt = new \DateTime();
        $this->subscriberBoxExtPdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->customers = new ArrayCollection();
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

    public function getSubscriberBox(): ?SubscriberBox
    {
        return $this->subscriberBox;
    }

    public function setSubscriberBox(?SubscriberBox $subscriberBox): self
    {
        $this->subscriberBox = $subscriberBox;

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

    /**
     * @return Collection|SubscriberBoxExtPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(SubscriberBoxExtPdf $subscriberBoxExtPdf): self
    {
        if (!$this->pdfs->contains($subscriberBoxExtPdf)) {
            $this->pdfs[] = $subscriberBoxExtPdf;
            $subscriberBoxExtPdf->setSubscriberBoxExt($this);
        }

        return $this;
    }

    public function removePdf(SubscriberBoxExtPdf $subscriberBoxExtPdf): self
    {
        if ($this->pdfs->contains($subscriberBoxExtPdf)) {
            $this->pdfs->removeElement($subscriberBoxExtPdf);
            // set the owning side to null (unless already changed)
            if ($subscriberBoxExtPdf->getSubscriberBoxExt() === $this) {
                $subscriberBoxExtPdf->setSubscriberBoxExt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SubscriberBoxExtImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(SubscriberBoxExtImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setSubscriberBoxExt($this);
        }

        return $this;
    }

    public function removeImage(SubscriberBoxExtImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getSubscriberBoxExt() === $this) {
                $image->setSubscriberBoxExt(null);
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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
    
    public function __toString() {
        return $this->name;
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
            $customer->setSubscriberBoxExt($this);
        }

        return $this;
    }

    public function removeCustomer(SubscriberBoxCustomer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getSubscriberBoxExt() === $this) {
                $customer->setSubscriberBoxExt(null);
            }
        }

        return $this;
    }
}
