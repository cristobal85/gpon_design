<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EdfaPortRepository")
 */
class EdfaPort
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"path"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"path"})
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EdfaSlot", inversedBy="edfaPorts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"path"})
     */
    private $edfaSlot;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LatiguilloEdfa", mappedBy="edfaPort", cascade={"persist", "remove"})
     * @Groups({"path"})
     */
    private $latiguilloEdfa;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LatiguilloPatch", mappedBy="edfaPort", cascade={"persist", "remove"})
     * @Groups({"path"})
     */
    private $latiguilloPatch;

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

    public function __toString() {
        return $this->edfaSlot. '_Puerto-'. $this->number;
    }

    public function getEdfaSlot(): ?EdfaSlot
    {
        return $this->edfaSlot;
    }

    public function setEdfaSlot(?EdfaSlot $edfaSlot): self
    {
        $this->edfaSlot = $edfaSlot;

        return $this;
    }

    public function getLatiguilloEdfa(): ?LatiguilloEdfa
    {
        return $this->latiguilloEdfa;
    }

    public function setLatiguilloEdfa(LatiguilloEdfa $latiguilloEdfa): self
    {
        $this->latiguilloEdfa = $latiguilloEdfa;

        // set the owning side of the relation if necessary
        if ($this !== $latiguilloEdfa->getEdfaPort()) {
            $latiguilloEdfa->setEdfaPort($this);
        }

        return $this;
    }

    public function getLatiguilloPatch(): ?LatiguilloPatch
    {
        return $this->latiguilloPatch;
    }

    public function setLatiguilloPatch(LatiguilloPatch $latiguilloPatch): self
    {
        $this->latiguilloPatch = $latiguilloPatch;

        // set the owning side of the relation if necessary
        if ($this !== $latiguilloPatch->getEdfaPort()) {
            $latiguilloPatch->setEdfaPort($this);
        }

        return $this;
    }
}
