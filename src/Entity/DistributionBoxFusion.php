<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistributionBoxFusionRepository")
 */
class DistributionBoxFusion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"distribution-box","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"distribution-box"})
     */
    private $signalLoss = 0.2;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fiber", inversedBy="distributionBoxFusions")
     * @Groups({"distribution-box","path"})
     */
    private $fibers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DistributionBox", inversedBy="distributionBoxFusions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"distribution-box","path"})
     */
    private $distributionBox;

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

    public function setSignalLoss(float $signalLoss): self
    {
        $this->signalLoss = $signalLoss;

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
        }

        return $this;
    }

    public function removeFiber(Fiber $fiber): self
    {
        if ($this->fibers->contains($fiber)) {
            $this->fibers->removeElement($fiber);
        }

        return $this;
    }

    public function getDistributionBox(): ?DistributionBox
    {
        return $this->distributionBox;
    }

    public function setDistributionBox(?DistributionBox $distributionBox): self
    {
        $this->distributionBox = $distributionBox;

        return $this;
    }
    
    public function __toString() {
        $name = "Caja-". $this->distributionBox;
        foreach ($this->fibers as $fiber) {
            $name .= "___Fibra-". $fiber;
        }
        return $name;
    }
}
