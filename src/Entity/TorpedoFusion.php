<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TorpedoFusionRepository")
 */
class TorpedoFusion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"torpedo","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"torpedo"})
     */
    private $signalLoss = 0.2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Torpedo", inversedBy="torpedoFusions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"torpedo","path"})
     */
    private $torpedo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fiber", mappedBy="torpedoFusions")
     * @ORM\JoinTable(name="fiber_torpedo_fusion")
     * @Assert\Count(
     *      min = 2,
     *      max = 2,
     *      exactMessage = "La fusión debe estar compuesta de 2 fibras."
     * )
     * @Groups({"torpedo","path"})
     */
    private $fibers;

    public function __construct()
    {
        $this->fibers = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignalLoss(): ?float
    {
        return $this->signalLoss;
    }

    public function setSignalLoss(?float $signalLoss): self
    {
        $this->signalLoss = $signalLoss;

        return $this;
    }

    public function getTorpedo(): ?Torpedo
    {
        return $this->torpedo;
    }

    public function setTorpedo(?Torpedo $torpedo): self
    {
        $this->torpedo = $torpedo;

        return $this;
    }

    public function __toString() {
        $name = "Torpedo-". $this->torpedo;
        foreach ($this->fibers as $fiber) {
            $name .= "___Fibra-". $fiber;
        }
        return $name;
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
            $fiber->addTorpedoFusion($this);
        }

        return $this;
    }

    public function removeFiber(Fiber $fiber): self
    {
        if ($this->fibers->contains($fiber)) {
            $this->fibers->removeElement($fiber);
            $fiber->removeTorpedoFusion($this);
        }

        return $this;
    }
    
    public function existFiber(Fiber $fiber) {
        return $this->fibers->contains($fiber);
    }
    
    
    public function removeAllFibers() {
        foreach ($this->fibers as $fiber) {
            $this->removeFiber($fiber);
        }
        
        return $this;
    }
    
    public function delete() {
        $this->torpedo->removeTorpedoFusion($this);
        
        return $this;
    }
    
}
