<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LatiguilloEdfaRepository")
 */
class LatiguilloEdfa
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\OltPort", inversedBy="latiguilloEdfa", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Debes seleccionar un PON.")
     */
    private $oltPort;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EdfaPort", inversedBy="latiguilloEdfa", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Debes seleccionar un Puerto de EDFA.")
     */
    private $edfaPort;

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

    public function getOltPort(): ?OltPort
    {
        return $this->oltPort;
    }

    public function setOltPort(OltPort $oltPort): self
    {
        $this->oltPort = $oltPort;

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
    
    public function __toString() {
        return $this->name;
    }
}
