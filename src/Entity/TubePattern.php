<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TubePatternRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TubePattern
{
    
    /**
     * @type int
     */
    public const DEFAULT_LAYER = 1;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=9)
     * @Assert\NotBlank
     */
    private $hexaColor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WirePattern", inversedBy="tubePatterns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wirePattern;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $layer;
    

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

    public function getLayer(): ?int
    {
        return $this->layer;
    }

    public function setLayer(?int $layer): self
    {
        $this->layer = $layer;

        return $this;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function prePersistLayer() {
        if (!$this->layer) {
            $this->layer = self::DEFAULT_LAYER;
        }
    }
}
