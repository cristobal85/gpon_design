<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistributionBoxSignalRepository")
 */
class DistributionBoxSignal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $tv;

    /**
     * @ORM\Column(type="float")
     */
    private $down;

    /**
     * @ORM\Column(type="float")
     */
    private $up;

    /**
     * @ORM\Column(type="datetime")
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DistributionBox", inversedBy="distributionBoxSignals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distributionBox;
    
    public function __construct() {
        $this->day = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTv(): ?float
    {
        return $this->tv;
    }

    public function setTv(float $tv): self
    {
        $this->tv = $tv;

        return $this;
    }

    public function getDown(): ?float
    {
        return $this->down;
    }

    public function setDown(float $down): self
    {
        $this->down = $down;

        return $this;
    }

    public function getUp(): ?float
    {
        return $this->up;
    }

    public function setUp(float $up): self
    {
        $this->up = $up;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

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
}
