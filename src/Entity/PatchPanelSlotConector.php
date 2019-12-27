<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatchPanelSlotConectorRepository")
 */
class PatchPanelSlotConector
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
     * @ORM\ManyToOne(targetEntity="App\Entity\PatchPanelSlot", inversedBy="patchPanelslotConectors")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cpd","path"})
     */
    private $patchPanelSlot;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LatiguilloPatch", mappedBy="patchPanelSlotConector", cascade={"persist", "remove"})
     * @Groups({"cpd"})
     */
    private $latiguilloPatch;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Fiber", inversedBy="patchPanelSlotConector", cascade={"persist"})
     * @Groups({"cpd","path","patch-panel"})
     */
    private $fiber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"cpd","path","patch-panel"})
     */
    private $description;

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

    public function getPatchPanelSlot(): ?PatchPanelSlot
    {
        return $this->patchPanelSlot;
    }

    public function setPatchPanelSlot(?PatchPanelSlot $patchPanelSlot): self
    {
        $this->patchPanelSlot = $patchPanelSlot;

        return $this;
    }

    public function __toString() {
        return $this->patchPanelSlot. '_Conector-'. $this->number;
    }

    public function getLatiguilloPatch(): ?LatiguilloPatch
    {
        return $this->latiguilloPatch;
    }

    public function setLatiguilloPatch(LatiguilloPatch $latiguilloPatch): self
    {
        $this->latiguilloPatch = $latiguilloPatch;

        // set the owning side of the relation if necessary
        if ($this !== $latiguilloPatch->getPatchPanelSlotConector()) {
            $latiguilloPatch->setPatchPanelSlotConector($this);
        }

        return $this;
    }

    public function getFiber(): ?Fiber
    {
        return $this->fiber;
    }

    public function setFiber(?Fiber $fiber): self
    {
        $this->fiber = $fiber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
