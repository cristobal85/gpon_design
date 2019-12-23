<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistributionBoxPassantRepository")
 */
class DistributionBoxPassant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"distribution-box","path"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DistributionBox", inversedBy="passants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"distribution-box","path"})
     */
    private $distributionBox;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fiber", inversedBy="distributionBoxPassants")
     * @ORM\JoinTable(name="fiber_distribution_box_passant")
     * @Assert\Count(
     *      min = 2,
     *      max = 2,
     *      exactMessage = "El pasante debe estar compuesto de 2 fibras."
     * )
     * @Groups({"distribution-box","path"})
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

    public function getDistributionBox(): ?DistributionBox
    {
        return $this->distributionBox;
    }

    public function setDistributionBox(?DistributionBox $distributionBox): self
    {
        $this->distributionBox = $distributionBox;

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
        $this->distributionBox->removePassant($this);
    }
}
