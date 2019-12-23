<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatchPanelRepository")
 */
class PatchPanel
{
    
    /**
     * PatchPanel pattern to create Slot and Port when PatchPanel is created.
     */
    private const PATCH_SLOT_NUM = array('first' =>  1, 'last'  =>  12);
    private const PATCH_PORT_NUM = array('first' =>  1, 'last'  =>  12);
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"cpd","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cpd","path"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rack", inversedBy="patchPanels")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cpd","path"})
     */
    private $rack;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatchPanelSlot", mappedBy="patchPanel", orphanRemoval=true)
     * @Groups({"cpd"})
     */
    private $patchPanelSlots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatchPanelPdf", mappedBy="patchPanel", cascade={"persist"})
     * @Assert\Valid
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatchPanelImage", mappedBy="patchPanel", cascade={"persist"})
     * @Assert\Valid
     */
    private $images;

    public function __construct()
    {
        $this->patchPanelSlots = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
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
     * @return Collection|PatchPanelSlot[]
     */
    public function getPatchPanelSlots(): Collection
    {
        return $this->patchPanelSlots;
    }

    public function addPathPanelSlot(PatchPanelSlot $patchPanelSlot): self
    {
        if (!$this->patchPanelSlots->contains($patchPanelSlot)) {
            $this->patchPanelSlots[] = $patchPanelSlot;
            $patchPanelSlot->setPathPanel($this);
        }

        return $this;
    }

    public function removePathPanelSlot(PatchPanelSlot $patchPanelSlot): self
    {
        if ($this->patchPanelSlots->contains($patchPanelSlot)) {
            $this->patchPanelSlots->removeElement($patchPanelSlot);
            // set the owning side to null (unless already changed)
            if ($patchPanelSlot->getPathPanel() === $this) {
                $patchPanelSlot->setPathPanel(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->rack. '_'. $this->name;
    }
    
    public function getPatchSlotNums() : array {
        return self::PATCH_SLOT_NUM;
    }
    
    public function getPatchPortNums() : array {
        return self::PATCH_PORT_NUM;
    }

    /**
     * @return Collection|PatchPanelPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(PatchPanelPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setPatchPanel($this);
        }

        return $this;
    }

    public function removePdf(PatchPanelPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getPatchPanel() === $this) {
                $pdf->setPatchPanel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PatchPanelImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(PatchPanelImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPatchPanel($this);
        }

        return $this;
    }

    public function removeImage(PatchPanelImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPatchPanel() === $this) {
                $image->setPatchPanel(null);
            }
        }

        return $this;
    }
}
