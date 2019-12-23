<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 * @Vich\Uploadable
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"map","cpd"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cpd"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cpd"})
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cpd", mappedBy="company")
     */
    private $cpds;

    /**
     * 
     * @Vich\UploadableField(mapping="images_upload", fileNameProperty="logo")
     * 
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"map"})
     */
    private $logo;
    
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;
    

    public function __construct()
    {
        $this->cpds = new ArrayCollection();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Cpd[]
     */
    public function getCpds(): Collection
    {
        return $this->cpds;
    }

    public function addCpd(Cpd $cpd): self
    {
        if (!$this->cpds->contains($cpd)) {
            $this->cpds[] = $cpd;
            $cpd->setCompany($this);
        }

        return $this;
    }

    public function removeCpd(Cpd $cpd): self
    {
        if ($this->cpds->contains($cpd)) {
            $this->cpds->removeElement($cpd);
            // set the owning side to null (unless already changed)
            if ($cpd->getCompany() === $this) {
                $cpd->setCompany(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }
}
