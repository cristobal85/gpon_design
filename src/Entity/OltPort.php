<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OltPortRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OltPort
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OltSlot", inversedBy="oltPorts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $oltSlot;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LatiguilloEdfa", mappedBy="oltPort", cascade={"persist", "remove"})
     */
    private $latiguilloEdfa;

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

    public function getOltSlot(): ?OltSlot
    {
        return $this->oltSlot;
    }

    public function setOltSlot(?OltSlot $oltSlot): self
    {
        $this->oltSlot = $oltSlot;

        return $this;
    }

    public function __toString() {
        return $this->oltSlot. '_PON-'. $this->number;
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createName() {
        $oltSlot = (string)$this->oltSlot->getNumber();
        $ponNumber = (string)$this->number;
        $this->setName($oltSlot. ".". $ponNumber);
    }

    public function getLatiguilloEdfa(): ?LatiguilloEdfa
    {
        return $this->latiguilloEdfa;
    }

    public function setLatiguilloEdfa(LatiguilloEdfa $latiguilloEdfa): self
    {
        $this->latiguilloEdfa = $latiguilloEdfa;

        // set the owning side of the relation if necessary
        if ($this !== $latiguilloEdfa->getOltPort()) {
            $latiguilloEdfa->setOltPort($this);
        }

        return $this;
    }
}
