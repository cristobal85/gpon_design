<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FiberRepository")
 */
class Fiber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $hexaColor;
    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tube", inversedBy="fibers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"map","form","torpedo","distribution-box","path"})
     */
    private $tube;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TorpedoFusion", inversedBy="fibers", orphanRemoval=true)
     * @ORM\JoinTable(name="fiber_torpedo_fusion")
     * @Assert\Count(
     *      min = 0,
     *      max = 2,
     *      maxMessage = "Una fibra no puede estar en mas de {{ limit }} torpedos."
     * )
     * @Groups({"map","form","path"})
     */
    private $torpedoFusions;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PatchPanelSlotConector", mappedBy="fiber")
     * @Groups({"map","form","path"})
     */
    private $patchPanelSlotConector;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DistributionBoxPort", mappedBy="fiber", cascade={"persist"})
     * @Groups({"map","form","distribution-box","path"})
     */
    private $distributionBoxPort;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TorpedoPassant", inversedBy="fibers", orphanRemoval=true)
     * @ORM\JoinTable(name="fiber_torpedo_passant")
     * @Assert\Count(
     *      min = 0,
     *      max = 2,
     *      maxMessage = "Una fibra no puede estar en mas de {{ limit }} pasantes de torpedo."
     * )
     * @Groups({"map","form","path"})
     */
    private $torpedoPassants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DistributionBoxPassant", mappedBy="fibers")
     * @ORM\JoinTable(name="fiber_distribution_box_passant")
     * @Assert\Count(
     *      min = 0,
     *      max = 2,
     *      maxMessage = "Una fibra no puede estar en mas de {{ limit }} pasantes de cajas de distribución."
     * )
     * @Groups({"map","form","path"})
     */
    private $distributionBoxPassants;
    

    public function __construct()
    {
        $this->torpedoFusions = new ArrayCollection();
        $this->torpedoPassants = new ArrayCollection();
        $this->distributionBoxPassants = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    public function getTube(): ?Tube
    {
        return $this->tube;
    }

    public function setTube(?Tube $tube): self
    {
        $this->tube = $tube;

        return $this;
    }

    public function __toString() {
        return $this->tube. '_'. $this->color;
    }

    /**
     * @return Collection|TorpedoFusion[]
     */
    public function getTorpedoFusions(): Collection
    {
        return $this->torpedoFusions;
    }

    public function addTorpedoFusion(TorpedoFusion $torpedoFusion): self
    {
        if (!$this->torpedoFusions->contains($torpedoFusion)) {
            $this->torpedoFusions[] = $torpedoFusion;
        }

        return $this;
    }

    public function removeTorpedoFusion(TorpedoFusion $torpedoFusion): self
    {
        if ($this->torpedoFusions->contains($torpedoFusion)) {
            $this->torpedoFusions->removeElement($torpedoFusion);
        }

        return $this;
    }
    
    /**
     * @param TorpedoFusion[] $torpedoFusions
     * @return \self
     */
    public function setTorpedoFusions($torpedoFusions = null): self
    {
        $this->torpedoFusions = $torpedoFusions;
        
        return $this;
    }
    
    public function setPatchPanelSlotConector(PatchPanelSlotConector $patchPanelSlotConector) {
        $this->patchPanelSlotConector = $patchPanelSlotConector;
        
        return $this;
    }
    
    /**
     * @return PatchPanelSlotConector|null
     */
    public function getPatchPanelSlotConector() {
        return $this->patchPanelSlotConector;
    }

    public function getDistributionBoxPort(): ?DistributionBoxPort
    {
        return $this->distributionBoxPort;
    }

    public function setDistributionBoxPort(?DistributionBoxPort $distributionBoxPort): self
    {
        $this->distributionBoxPort = $distributionBoxPort;

        // set (or unset) the owning side of the relation if necessary
        $newFiber = null === $distributionBoxPort ? null : $this;
        if ($distributionBoxPort->getFiber() !== $newFiber) {
            $distributionBoxPort->setFiber($newFiber);
        }

        return $this;
    }

    /**
     * @return Collection|TorpedoPassant[]
     */
    public function getTorpedoPassants(): Collection
    {
        return $this->torpedoPassants;
    }

    public function addTorpedoPassant(TorpedoPassant $torpedoPassant): self
    {
        if (!$this->torpedoPassants->contains($torpedoPassant)) {
            $this->torpedoPassants[] = $torpedoPassant;
            $torpedoPassant->addFiber($this);
        }

        return $this;
    }

    public function removeTorpedoPassant(TorpedoPassant $torpedoPassant): self
    {
        if ($this->torpedoPassants->contains($torpedoPassant)) {
            $this->torpedoPassants->removeElement($torpedoPassant);
            $torpedoPassant->removeFiber($this);
        }

        return $this;
    }
    
    /**
     * 
     * @param TorpedoPassant[] $torpedoPassants
     * @return \self
     */
    public function setTorpedoPassants($torpedoPassants = null): self
    {
        $this->torpedoPassants = $torpedoPassants;
        
        return $this;
    }
    
    public function deleteFusionAndPasants() 
    {
        foreach ($this->torpedoFusions as $torpedoFusion) {
            $torpedoFusion->removeAllFibers();
            $torpedoFusion->delete();
        }
        $this->setTorpedoFusions(null);
        
        foreach ($this->torpedoPassants as $torpedoPassant) {
            $torpedoPassant->removeAllFibers();
            $torpedoPassant->delete();
        }
        $this->setTorpedoPassants(null);
        
        foreach ($this->distributionBoxPassants as $dsBoxPassant) {
            $dsBoxPassant->removeAllFibers();
            $dsBoxPassant->delete();
        }
        $this->setDistributionBoxPassants(null);
        
        if (!empty($this->distributionBoxPort)) {
            $this->distributionBoxPort->setFiber(null);
        }
        
        if (!empty($this->patchPanelSlotConector)) {
            $this->patchPanelSlotConector->setFiber(null);
        }
    }
    
    /**
     * Devuelve la fusion o pasante para poder seguir la trayectoria
     * @return TorpedoFusion[]|TorpedoPassant[]|null
     */
    public function getTorpedoFun() {
        if (!empty($this->torpedoFusions)) {
            return $this->torpedoFusions;
        }
        if (!empty($this->torpedoPassants)) {
            return $this->torpedoPassants;
        }
        
        return null;
    }

    /**
     * @return Collection|DistributionBoxPassant[]
     */
    public function getDistributionBoxPassants(): Collection
    {
        return $this->distributionBoxPassants;
    }

    public function addDistributionBoxPassant(DistributionBoxPassant $distributionBoxPassant): self
    {
        if (!$this->distributionBoxPassants->contains($distributionBoxPassant)) {
            $this->distributionBoxPassants[] = $distributionBoxPassant;
            $distributionBoxPassant->addFiber($this);
        }

        return $this;
    }

    public function removeDistributionBoxPassant(DistributionBoxPassant $distributionBoxPassant): self
    {
        if ($this->distributionBoxPassants->contains($distributionBoxPassant)) {
            $this->distributionBoxPassants->removeElement($distributionBoxPassant);
            $distributionBoxPassant->removeFiber($this);
        }

        return $this;
    }
    
    
    public function setDistributionBoxPassants($dsBoxPassants = null): self 
    {
        $this->distributionBoxPassants = $dsBoxPassants;
        
        return $this;
    }
}
