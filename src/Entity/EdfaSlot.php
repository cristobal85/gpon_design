<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EdfaSlotRepository")
 */
class EdfaSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"path"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Edfa", inversedBy="edfaSlots")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"path"})
     */
    private $edfa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EdfaPort", mappedBy="edfaSlot", orphanRemoval=true)
     */
    private $edfaPorts;

    public function __construct()
    {
        $this->edfaPorts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEdfa(): ?Edfa
    {
        return $this->edfa;
    }

    public function setEdfa(?Edfa $edfa): self
    {
        $this->edfa = $edfa;

        return $this;
    }

    /**
     * @return Collection|EdfaPort[]
     */
    public function getEdfaPorts(): Collection
    {
        return $this->edfaPorts;
    }

    public function addEdfaPort(EdfaPort $edfaPort): self
    {
        if (!$this->edfaPorts->contains($edfaPort)) {
            $this->edfaPorts[] = $edfaPort;
            $edfaPort->setEdfaSlot($this);
        }

        return $this;
    }

    public function removeEdfaPort(EdfaPort $edfaPort): self
    {
        if ($this->edfaPorts->contains($edfaPort)) {
            $this->edfaPorts->removeElement($edfaPort);
            // set the owning side to null (unless already changed)
            if ($edfaPort->getEdfaSlot() === $this) {
                $edfaPort->setEdfaSlot(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->edfa. '_'. $this->type;
    }
}
