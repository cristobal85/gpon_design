<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CpdRepository")
 */
class Cpd
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cpd"})
     */
    private $location;

    /**
     * @ORM\Column(type="float")
     * @Groups({"map"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"map"})
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="cpds")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"map","cpd"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rack", mappedBy="cpd", orphanRemoval=true)
     * @Groups({"cpd"})
     */
    private $racks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CpdPdf", mappedBy="cpd", cascade={"persist"})
     * @Assert\Valid
     * @Groups({"cpd"})
     */
    private $pdfs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CpdImage", mappedBy="cpd", cascade={"persist"})
     * @Assert\Valid
     * @Groups({"cpd"})
     */
    private $images;

    public function __construct()
    {
        $this->racks = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Rack[]
     */
    public function getRacks(): Collection
    {
        return $this->racks;
    }

    public function addRack(Rack $rack): self
    {
        if (!$this->racks->contains($rack)) {
            $this->racks[] = $rack;
            $rack->setCpd($this);
        }

        return $this;
    }

    public function removeRack(Rack $rack): self
    {
        if ($this->racks->contains($rack)) {
            $this->racks->removeElement($rack);
            // set the owning side to null (unless already changed)
            if ($rack->getCpd() === $this) {
                $rack->setCpd(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->location;
    }

    /**
     * @return Collection|CpdPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(CpdPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setCpd($this);
        }

        return $this;
    }

    public function removePdf(CpdPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getCpd() === $this) {
                $pdf->setCpd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CpdImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(CpdImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCpd($this);
        }

        return $this;
    }

    public function removeImage(CpdImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getCpd() === $this) {
                $image->setCpd(null);
            }
        }

        return $this;
    }
}
