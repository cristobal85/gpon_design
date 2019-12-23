<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TorpedoPassantRepository")
 */
class TorpedoPassant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"torpedo","path"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Torpedo", inversedBy="passants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"torpedo", "path"})
     */
    private $torpedo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fiber", mappedBy="torpedoPassants")
     * @ORM\JoinTable(name="fiber_torpedo_passant")
     * @Assert\Count(
     *      min = 2,
     *      max = 2,
     *      exactMessage = "El pasante debe estar compuesto de 2 fibras."
     * )
     * @Groups({"torpedo", "path"})
     */
    private $fibers;

    public function __construct()
    {
        $this->fibers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTorpedo(): ?Torpedo
    {
        return $this->torpedo;
    }

    public function setTorpedo(?Torpedo $torpedo): self
    {
        $this->torpedo = $torpedo;

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
            $fiber->addTorpedoPassant($this);
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
    
    public function removeAllFibers() {
        foreach ($this->fibers as $fiber) {
            $this->removeFiber($fiber);
        }
        
        return $this;
    }
    
    public function existFiber(Fiber $fiber) {
        return $this->fibers->contains($fiber);
    }
    
    public function delete() {
        $this->torpedo->removePassant($this);
    }
}
