<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 */
class Map
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
     * @Groups({"map"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map"})
     */
    private $displayName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"map"})
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"map"})
     */
    private $minZoom;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"map"})
     */
    private $maxZoom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cpd", inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cpd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"map"})
     */
    private $defaultMap;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"map"})
     */
    private $wms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"map"})
     */
    private $version;


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

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMinZoom(): ?int
    {
        return $this->minZoom;
    }

    public function setMinZoom(int $minZoom): self
    {
        $this->minZoom = $minZoom;

        return $this;
    }

    public function getMaxZoom(): ?int
    {
        return $this->maxZoom;
    }

    public function setMaxZoom(int $maxZoom): self
    {
        $this->maxZoom = $maxZoom;

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

    public function getDefaultMap(): ?bool
    {
        return $this->defaultMap;
    }

    public function setDefaultMap(?bool $defaultMap): self
    {
        $this->defaultMap = $defaultMap;

        return $this;
    }

    public function getWms(): ?bool
    {
        return $this->wms;
    }

    public function setWms(bool $wms): self
    {
        $this->wms = $wms;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
