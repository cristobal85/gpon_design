<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatchPanelSlotRepository")
 */
class PatchPanelSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"cpd","path","patch-panel"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"cpd","path","patch-panel"})
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PatchPanel", inversedBy="patchPanelSlots")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cpd","path"})
     */
    private $patchPanel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatchPanelSlotConector", mappedBy="patchPanelSlot", orphanRemoval=true)
     * @Groups({"cpd","path","patch-panel"})
     */
    private $patchPanelSlotConectors;

    public function __construct()
    {
        $this->patchPanelSlotConectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPatchPanel(): ?PatchPanel
    {
        return $this->patchPanel;
    }

    public function setPatchPanel(?PatchPanel $patchPanel): self
    {
        $this->patchPanel = $patchPanel;

        return $this;
    }

    /**
     * @return Collection|PatchPanelSlotConector[]
     */
    public function getPatchPanelSlotConectors(): Collection
    {
        return $this->patchPanelSlotConectors;
    }

    public function addPatchPanelSlotConector(PatchPanelSlotConector $patchPanelSlotConector): self
    {
        if (!$this->patchPanelSlotConectors->contains($patchPanelSlotConector)) {
            $this->patchPanelSlotConectors[] = $patchPanelSlotConector;
            $patchPanelSlotConector->setPatchPanelSlot($this);
        }

        return $this;
    }

    public function removePatchPanelSlotConector(PatchPanelSlotConector $patchPanelSlotConector): self
    {
        if ($this->patchPanelSlotConectors->contains($patchPanelSlotConector)) {
            $this->patchPanelSlotConectors->removeElement($patchPanelSlotConector);
            // set the owning side to null (unless already changed)
            if ($patchPanelSlotConector->getPatchPanelSlot() === $this) {
                $patchPanelSlotConector->setPatchPanelSlot(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->patchPanel. '_Slot-'. $this->number;
    }
    
}
