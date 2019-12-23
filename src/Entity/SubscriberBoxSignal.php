<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberBoxSignalRepository")
 */
class SubscriberBoxSignal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"subscriber-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"subscriber-box"})
     */
    private $tv;

    /**
     * @ORM\Column(type="float")
     * @Groups({"subscriber-box"})
     */
    private $down;

    /**
     * @ORM\Column(type="float")
     * @Groups({"subscriber-box"})
     */
    private $up;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"subscriber-box"})
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscriberBox", inversedBy="subscriberBoxSignals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriberBox;
    
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

    public function getSubscriberBox(): ?SubscriberBox
    {
        return $this->subscriberBox;
    }

    public function setSubscriberBox(?SubscriberBox $subscriberBox): self
    {
        $this->subscriberBox = $subscriberBox;

        return $this;
    }
}
