<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RackRepository")
 */
class Rack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"cpd","path"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cpd","path","cpd"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cpd", inversedBy="racks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cpd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Edfa", mappedBy="rack", orphanRemoval=true)
     */
    private $edfas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Olt", mappedBy="rack", orphanRemoval=true)
     */
    private $olts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatchPanel", mappedBy="rack", orphanRemoval=true)
     * @Groups({"cpd"})
     */
    private $patchPanels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RackPdf", mappedBy="rack", cascade={"persist"})
     * @Assert\Valid
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RackImage", mappedBy="rack", cascade={"persist"})
     * @Assert\Valid
     */
    private $images;

    public function __construct()
    {
        $this->edfas = new ArrayCollection();
        $this->olts = new ArrayCollection();
        $this->patchPanels = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

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

    public function getCpd(): ?Cpd
    {
        return $this->cpd;
    }

    public function setCpd(?Cpd $cpd): self
    {
        $this->cpd = $cpd;

        return $this;
    }

    /**
     * @return Collection|Edfa[]
     */
    public function getEdfas(): Collection
    {
        return $this->edfas;
    }

    public function addEdfa(Edfa $edfa): self
    {
        if (!$this->edfas->contains($edfa)) {
            $this->edfas[] = $edfa;
            $edfa->setRack($this);
        }

        return $this;
    }

    public function removeEdfa(Edfa $edfa): self
    {
        if ($this->edfas->contains($edfa)) {
            $this->edfas->removeElement($edfa);
            // set the owning side to null (unless already changed)
            if ($edfa->getRack() === $this) {
                $edfa->setRack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Olt[]
     */
    public function getOlts(): Collection
    {
        return $this->olts;
    }

    public function addOlt(Olt $olt): self
    {
        if (!$this->olts->contains($olt)) {
            $this->olts[] = $olt;
            $olt->setRack($this);
        }

        return $this;
    }

    public function removeOlt(Olt $olt): self
    {
        if ($this->olts->contains($olt)) {
            $this->olts->removeElement($olt);
            // set the owning side to null (unless already changed)
            if ($olt->getRack() === $this) {
                $olt->setRack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PatchPanel[]
     */
    public function getPatchPanels(): Collection
    {
        return $this->patchPanels;
    }

    public function addPatchPanel(PatchPanel $patchPanel): self
    {
        if (!$this->patchPanels->contains($patchPanel)) {
            $this->patchPanels[] = $patchPanel;
            $patchPanel->setRack($this);
        }

        return $this;
    }

    public function removePathPanel(PatchPanel $patchPanel): self
    {
        if ($this->patchPanels->contains($patchPanel)) {
            $this->patchPanels->removeElement($patchPanel);
            // set the owning side to null (unless already changed)
            if ($patchPanel->getRack() === $this) {
                $patchPanel->setRack(null);
            }
        }

        return $this;
    }
    
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|RackPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(RackPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setRack($this);
        }

        return $this;
    }

    public function removePdf(RackPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getRack() === $this) {
                $pdf->setRack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RackImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(RackImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRack($this);
        }

        return $this;
    }

    public function removeImage(RackImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getRack() === $this) {
                $image->setRack(null);
            }
        }

        return $this;
    }
}