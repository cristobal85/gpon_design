<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NodoRepository")
 */
class Nodo
{
    /**
     * Nodo pattern to create distribution and subscriber box when nodo is created.
     */
    public const ID_DISTIRUBTION_BOX = array('A','B','C','D');
    public const ID_SUBSCRIBER_BOX = array('1','2','3','4','5','6','7','8');
    
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
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DistributionBox", mappedBy="nodo", orphanRemoval=true)
     */
    private $distributionBox;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NodoPdf", mappedBy="nodo", cascade={"persist"})
     * @Assert\Valid
     */
    private $pdfs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Address", inversedBy="nodos", cascade={"persist"})
     */
    private $addresses;


    public function __construct()
    {
        $this->distributionBox = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->addresses = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    /**
     * @return Collection|DistributionBox[]
     */
    public function getDistributionBox(): Collection
    {
        return $this->distributionBox;
    }

    public function addDistributionBox(DistributionBox $distributionBox): self
    {
        if (!$this->distributionBox->contains($distributionBox)) {
            $this->distributionBox[] = $distributionBox;
            $distributionBox->setNodo($this);
        }

        return $this;
    }

    public function removeDistributionBox(DistributionBox $distributionBox): self
    {
        if ($this->distributionBox->contains($distributionBox)) {
            $this->distributionBox->removeElement($distributionBox);
            // set the owning side to null (unless already changed)
            if ($distributionBox->getNodo() === $this) {
                $distributionBox->setNodo(null);
            }
        }

        return $this;
    }
    
    
    public function __toString() {
        return (string)$this->number;
    }

    /**
     * @return Collection|NodoPdf[]
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(NodoPdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs[] = $pdf;
            $pdf->setNodo($this);
        }

        return $this;
    }

    public function removePdf(NodoPdf $pdf): self
    {
        if ($this->pdfs->contains($pdf)) {
            $this->pdfs->removeElement($pdf);
            // set the owning side to null (unless already changed)
            if ($pdf->getNodo() === $this) {
                $pdf->setNodo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->addNodo($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            $address->removeNodo($this);
        }

        return $this;
    }

}
