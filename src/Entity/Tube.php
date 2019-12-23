<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TubeRepository")
 */
class Tube
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"form","torpedo","distribution-box","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"form","torpedo","distribution-box","path"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $hexaColor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fiber", mappedBy="tube", orphanRemoval=true)
     * @Groups({"form"})
     */
    private $fibers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wire", inversedBy="tubes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $wire;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"form"})
     */
    private $layer;

    public function __construct()
    {
        $this->fibers = new ArrayCollection();
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

    public function getHexaColor(): ?string
    {
        return $this->hexaColor;
    }

    public function setHexaColor(string $hexaColor): self
    {
        $this->hexaColor = $hexaColor;

        return $this;
    }

    /**
     * @return Collection|Fiber[]
     */
    public function getFibers(): Collection
    {
        return $this->fibers;
    }

    public function addFiber(Fiber $fiber): self
    {
        if (!$this->fibers->contains($fiber)) {
            $this->fibers[] = $fiber;
            $fiber->setTube($this);
        }

        return $this;
    }

    public function removeFiber(Fiber $fiber): self
    {
        if ($this->fibers->contains($fiber)) {
            $this->fibers->removeElement($fiber);
            // set the owning side to null (unless already changed)
            if ($fiber->getTube() === $this) {
                $fiber->setTube(null);
            }
        }

        return $this;
    }

    public function getWire(): ?Wire
    {
        return $this->wire;
    }

    public function setWire(?Wire $wire): self
    {
        $this->wire = $wire;

        return $this;
    }
    
    
    public function __toString() {
        return $this->wire. '_'. $this->name. '-Layer_'. (string)$this->layer;
    }

    public function getLayer(): int
    {
        return $this->layer;
    }

    public function setLayer(int $layer): self
    {
        $this->layer = $layer;

        return $this;
    }
    
    public function deleteFusionAndPasants() {
        foreach ($this->fibers as $fiber) {
            $fiber->deleteFusionAndPasants();
        }
    }
}
