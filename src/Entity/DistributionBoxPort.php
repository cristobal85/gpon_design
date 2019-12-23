<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistributionBoxPortRepository")
 */
class DistributionBoxPort
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"distribution-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"distribution-box","path"})
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DistributionBox", inversedBy="ports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"distribution-box","path"})
     */
    private $distributionBox;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Fiber", inversedBy="distributionBoxPort", cascade={"persist"})
     * @Groups({"distribution-box","path"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $fiber;

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

    public function getDistributionBox(): ?DistributionBox
    {
        return $this->distributionBox;
    }

    public function setDistributionBox(?DistributionBox $distributionBox): self
    {
        $this->distributionBox = $distributionBox;

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
    
    public function __toString() {
        return $this->distributionBox. '-Port_'. (string)$this->number;
    }
}
