<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\LayerGroupRepository")
 */
class LayerGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map", "form"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map", "form"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wire", mappedBy="layerGroup", cascade={"persist"})
     * @Groups({"map"})
     */
    private $wires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBox", mappedBy="layerGroup", cascade={"persist"})
     * @Groups({"map"})
     */
    private $distributionBoxes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Torpedo", mappedBy="layerGroup", cascade={"persist"})
     * @Groups({"map"})
     */
    private $torpedos;

    /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     * @Groups({"map"})
     */
    private $hexaColor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"map"})
     */
    private $weight;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"map"})
     */
    private $coordinates = [];

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $position;
    

    public function __construct()
    {
        $this->wires = new ArrayCollection();
        $this->distributionBoxes = new ArrayCollection();
        $this->torpedos = new ArrayCollection();
        $this->subscriberBoxes = new ArrayCollection();
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

    /**
     * @return Collection|Wire[]
     */
    public function getWires(): Collection
    {
        return $this->wires;
    }

    public function addWire(Wire $wire): self
    {
        if (!$this->wires->contains($wire)) {
            $this->wires[] = $wire;
            $wire->setLayerGroup($this);
        }

        return $this;
    }

    public function removeWire(Wire $wire): self
    {
        if ($this->wires->contains($wire)) {
            $this->wires->removeElement($wire);
            // set the owning side to null (unless already changed)
            if ($wire->getLayerGroup() === $this) {
                $wire->setLayerGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DistributionBox[]
     */
    public function getDistributionBoxes(): Collection
    {
        return $this->distributionBoxes;
    }

    public function addDistributionBox(DistributionBox $distributionBox): self
    {
        if (!$this->distributionBoxes->contains($distributionBox)) {
            $this->distributionBoxes[] = $distributionBox;
            $distributionBox->setLayerGroup($this);
        }

        return $this;
    }

    public function removeDistributionBox(DistributionBox $distributionBox): self
    {
        if ($this->distributionBoxes->contains($distributionBox)) {
            $this->distributionBoxes->removeElement($distributionBox);
            // set the owning side to null (unless already changed)
            if ($distributionBox->getLayerGroup() === $this) {
                $distributionBox->setLayerGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Torpedo[]
     */
    public function getTorpedos(): Collection
    {
        return $this->torpedos;
    }

    public function addTorpedo(Torpedo $torpedo): self
    {
        if (!$this->torpedos->contains($torpedo)) {
            $this->torpedos[] = $torpedo;
            $torpedo->setLayerGroup($this);
        }

        return $this;
    }

    public function removeTorpedo(Torpedo $torpedo): self
    {
        if ($this->torpedos->contains($torpedo)) {
            $this->torpedos->removeElement($torpedo);
            // set the owning side to null (unless already changed)
            if ($torpedo->getLayerGroup() === $this) {
                $torpedo->setLayerGroup(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getHexaColor(): ?string
    {
        return $this->hexaColor;
    }

    public function setHexaColor(?string $hexaColor): self
    {
        $this->hexaColor = $hexaColor;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function setCoordinates(?array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

}
