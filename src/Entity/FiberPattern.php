<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FiberPatternRepository")
 */
class FiberPattern
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $hexaColor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WirePattern", inversedBy="fiberPatterns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wirePattern;

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

    public function getWirePattern(): ?WirePattern
    {
        return $this->wirePattern;
    }

    public function setWirePattern(?WirePattern $wirePattern): self
    {
        $this->wirePattern = $wirePattern;

        return $this;
    }

}
