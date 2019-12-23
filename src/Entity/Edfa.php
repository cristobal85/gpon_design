<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EdfaRepository")
 */
class Edfa
{
    
    /**
     * Edfa pattern to create Slot and Port when EDFA is created.
     */
    private const EDFA_SLOT_TYPE = array('IN','OUT');
    private const EDFA_PORT_NUM = array('first' =>  1, 'last'  =>  32);
    
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Rack", inversedBy="edfas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rack;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EdfaSlot", mappedBy="edfa", orphanRemoval=true)
     */
    private $edfaSlots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EdfaImage", mappedBy="edfa", cascade={"persist"})
     * @Assert\Valid
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EdfaPdf", mappedBy="edfa", cascade={"persist"})
     * @Assert\Valid
     */
    private $pdfs;

    public function __construct()
    {
        $this->edfaSlots = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
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
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|EdfaSlot[]
     */
    public function getEdfaSlots(): Collection
    {
        return $this->edfaSlots;
    }

    public function addEdfaSlot(EdfaSlot $edfaSlot): self
    {
        if (!$this->edfaSlots->contains($edfaSlot)) {
            $this->edfaSlots[] = $edfaSlot;
            $edfaSlot->setEdfa($this);
        }

        return $this;
    }

    public function removeEdfaSlot(EdfaSlot $edfaSlot): self
    {
        if ($this->edfaSlots->contains($edfaSlot)) {
            $this->edfaSlots->removeElement($edfaSlot);
            // set the owning side to null (unless already changed)
            if ($edfaSlot->getEdfa() === $this) {
                $edfaSlot->setEdfa(null);
            }
        }

        return $this;
    }
    
    public function getEdfaSlotTypes() : array {
        return self::EDFA_SLOT_TYPE;
    }
    
    public function getEdfaPortNum() : array {
        return self::EDFA_PORT_NUM;
    }

    /**
     * @return Collection|EdfaImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(EdfaImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setEdfa($this);
        }

        return $this;
    }

    public function removeImage(EdfaImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getEdfa() === $this) {
                $image->setEdfa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EdfaPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(EdfaPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setEdfa($this);
        }

        return $this;
    }

    public function removePdf(EdfaPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getEdfa() === $this) {
                $pdf->setEdfa(null);
            }
        }

        return $this;
    }
}
