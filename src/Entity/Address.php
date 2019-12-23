<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","torpedo","distribution-box","subscriber-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","torpedo","distribution-box","subscriber-box","path"})
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBox", mappedBy="address")
     * @Groups({"address"})
     */
    private $subscriberBoxes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBox", mappedBy="address")
     * @Groups({"address"})
     */
    private $distributionBoxes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Nodo", mappedBy="addresses")
     * @Groups({"address"})
     */
    private $nodos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubscriberBoxExt", mappedBy="address")
     * @Groups({"address"})
     */
    private $subscriberBoxesExt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Torpedo", mappedBy="address")
     * @Groups({"address"})
     */
    private $torpedos;

    public function __construct()
    {
        $this->subscriberBoxes = new ArrayCollection();
        $this->distributionBoxes = new ArrayCollection();
        $this->nodos = new ArrayCollection();
        $this->subscriberBoxesExt = new ArrayCollection();
        $this->torpedos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
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
            $subscriberBox->setAdresss($this);
        }

        return $this;
    }

    public function removeSubscriberBox(SubscriberBox $subscriberBox): self
    {
        if ($this->subscriberBoxes->contains($subscriberBox)) {
            $this->subscriberBoxes->removeElement($subscriberBox);
            // set the owning side to null (unless already changed)
            if ($subscriberBox->getAdresss() === $this) {
                $subscriberBox->setAdresss(null);
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
            $distributionBox->setAddresss($this);
        }

        return $this;
    }

    public function removeDistributionBox(DistributionBox $distributionBox): self
    {
        if ($this->distributionBoxes->contains($distributionBox)) {
            $this->distributionBoxes->removeElement($distributionBox);
            // set the owning side to null (unless already changed)
            if ($distributionBox->getAddresss() === $this) {
                $distributionBox->setAddresss(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nodo[]
     */
    public function getNodos(): Collection
    {
        return $this->nodos;
    }

    public function addNodo(Nodo $nodo): self
    {
        if (!$this->nodos->contains($nodo)) {
            $this->nodos[] = $nodo;
        }

        return $this;
    }

    public function removeNodo(Nodo $nodo): self
    {
        if ($this->nodos->contains($nodo)) {
            $this->nodos->removeElement($nodo);
        }

        return $this;
    }
    
    
    public function __toString() {
        return $this->location;
    }

    /**
     * @return Collection|SubscriberBoxExt[]
     */
    public function getSubscriberBoxesExt(): Collection
    {
        return $this->subscriberBoxesExt;
    }

    public function addSubscriberBoxesExt(SubscriberBoxExt $subscriberBoxesExt): self
    {
        if (!$this->subscriberBoxesExt->contains($subscriberBoxesExt)) {
            $this->subscriberBoxesExt[] = $subscriberBoxesExt;
            $subscriberBoxesExt->setAdresss($this);
        }

        return $this;
    }

    public function removeSubscriberBoxesExt(SubscriberBoxExt $subscriberBoxesExt): self
    {
        if ($this->subscriberBoxesExt->contains($subscriberBoxesExt)) {
            $this->subscriberBoxesExt->removeElement($subscriberBoxesExt);
            // set the owning side to null (unless already changed)
            if ($subscriberBoxesExt->getAdresss() === $this) {
                $subscriberBoxesExt->setAdresss(null);
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
            $torpedo->setAddress($this);
        }

        return $this;
    }

    public function removeTorpedo(Torpedo $torpedo): self
    {
        if ($this->torpedos->contains($torpedo)) {
            $this->torpedos->removeElement($torpedo);
            // set the owning side to null (unless already changed)
            if ($torpedo->getAddress() === $this) {
                $torpedo->setAddress(null);
            }
        }

        return $this;
    }
}
