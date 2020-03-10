<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LatiguilloPatchRepository")
 */
class LatiguilloPatch
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
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EdfaPort", inversedBy="latiguilloPatch", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Debes seleccionar un puerto de EDFA.")
     * @Groups({"path"})
     */
    private $edfaPort;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PatchPanelSlotConector", inversedBy="latiguilloPatch", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Debes seleccionar un puerto del Patch Panel.")
     * @Groups({"path"})
     */
    private $patchPanelSlotConector;

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

    public function getEdfaPort(): ?EdfaPort
    {
        return $this->edfaPort;
    }

    public function setEdfaPort(EdfaPort $edfaPort): self
    {
        $this->edfaPort = $edfaPort;

        return $this;
    }

    public function getPatchPanelSlotConector(): ?PatchPanelSlotConector
    {
        return $this->patchPanelSlotConector;
    }

    public function setPatchPanelSlotConector(PatchPanelSlotConector $patchPanelSlotConector): self
    {
        $this->patchPanelSlotConector = $patchPanelSlotConector;

        return $this;
    }
}
