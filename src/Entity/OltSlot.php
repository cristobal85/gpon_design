<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OltSlotRepository")
 */
class OltSlot
{
    
    /**
     * OltSlot pattern to create Ports when OltSlot is created.
     */
    private const OLT_PORT_NUM = array('first' =>  0, 'last'  =>  15);
    
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Olt", inversedBy="oltSlots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $olt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OltPort", mappedBy="oltSlot", orphanRemoval=true)
     */
    private $oltPorts;

    public function __construct()
    {
        $this->oltPorts = new ArrayCollection();
    }

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

    public function getOlt(): ?Olt
    {
        return $this->olt;
    }

    public function setOlt(?Olt $olt): self
    {
        $this->olt = $olt;

        return $this;
    }

    /**
     * @return Collection|OltPort[]
     */
    public function getOltPorts(): Collection
    {
        return $this->oltPorts;
    }

    public function addOltPort(OltPort $oltPort): self
    {
        if (!$this->oltPorts->contains($oltPort)) {
            $this->oltPorts[] = $oltPort;
            $oltPort->setOltSlot($this);
        }

        return $this;
    }

    public function removeOltPort(OltPort $oltPort): self
    {
        if ($this->oltPorts->contains($oltPort)) {
            $this->oltPorts->removeElement($oltPort);
            // set the owning side to null (unless already changed)
            if ($oltPort->getOltSlot() === $this) {
                $oltPort->setOltSlot(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->olt. '_Tarjeta-'. $this->number;
    }
    
    public function getOltPortNum() : array {
        return self::OLT_PORT_NUM;
    }
}
