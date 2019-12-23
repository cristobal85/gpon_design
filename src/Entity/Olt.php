<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OltRepository")
 */
class Olt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rack", inversedBy="olts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Debes seleccionar un Rack.")
     */
    private $rack;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OltSlot", mappedBy="olt", orphanRemoval=true)
     */
    private $oltSlots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OltPdf", mappedBy="olt", cascade={"persist"})
     * @Assert\Valid
     */
    private $oltPdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OltImage", mappedBy="olt", cascade={"persist"})
     * @Assert\Valid
     */
    private $images;

    public function __construct()
    {
        $this->oltSlots = new ArrayCollection();
        $this->oltPdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    public function getRack(): ?Rack
    {
        return $this->rack;
    }

    public function setRack(?Rack $rack): self
    {
        $this->rack = $rack;

        return $this;
    }

    /**
     * @return Collection|OltSlot[]
     */
    public function getOltSlots(): Collection
    {
        return $this->oltSlots;
    }

    public function addOltSlot(OltSlot $oltSlot): self
    {
        if (!$this->oltSlots->contains($oltSlot)) {
            $this->oltSlots[] = $oltSlot;
            $oltSlot->setOlt($this);
        }

        return $this;
    }

    public function removeOltSlot(OltSlot $oltSlot): self
    {
        if ($this->oltSlots->contains($oltSlot)) {
            $this->oltSlots->removeElement($oltSlot);
            // set the owning side to null (unless already changed)
            if ($oltSlot->getOlt() === $this) {
                $oltSlot->setOlt(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|OltPdf[]
     */
    public function getOltPdfs(): Collection
    {
        return $this->oltPdfs;
    }

    public function addOltPdf(OltPdf $oltPdf): self
    {
        if (!$this->oltPdfs->contains($oltPdf)) {
            $this->oltPdfs[] = $oltPdf;
            $oltPdf->setOlt($this);
        }

        return $this;
    }

    public function removeOltPdf(OltPdf $oltPdf): self
    {
        if ($this->oltPdfs->contains($oltPdf)) {
            $this->oltPdfs->removeElement($oltPdf);
            // set the owning side to null (unless already changed)
            if ($oltPdf->getOlt() === $this) {
                $oltPdf->setOlt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OltImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(OltImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setOlt($this);
        }

        return $this;
    }

    public function removeImage(OltImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getOlt() === $this) {
                $image->setOlt(null);
            }
        }

        return $this;
    }
}
