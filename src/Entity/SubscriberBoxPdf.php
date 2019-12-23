<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberBoxPdfRepository")
 * @Vich\Uploadable
 */
class SubscriberBoxPdf
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"subscriber-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"subscriber-box"})
     */
    private $filePath;
    
    /**
     * 
     * @Vich\UploadableField(mapping="files_upload", fileNameProperty="filePath")
     * @var File
     * @Assert\File(
     *     maxSize = "5192k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor, selecciona un archivo PDF válido"
     * )
     */
    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscriberBox", inversedBy="pdfs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriberBox;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
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

    public function getSubscriberBox(): ?SubscriberBox
    {
        return $this->subscriberBox;
    }

    public function setSubscriberBox(?SubscriberBox $subscriberBox): self
    {
        $this->subscriberBox = $subscriberBox;

        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString() {
        return "Archivo ". $this->filePath;
    }
}
