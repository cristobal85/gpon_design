<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberBoxCustomerRepository")
 */
class SubscriberBoxCustomer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"subscriber-box"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups({"subscriber-box"})
     * @Assert\NotBlank
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"subscriber-box"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"subscriber-box"})
     * @Assert\NotBlank
     */
    private $subscriberBoxOut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscriberBox", inversedBy="customers")
     */
    private $subscriberBox;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscriberBoxExt", inversedBy="customers")
     */
    private $subscriberBoxExt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"subscriber-box"})
     * @Assert\NotNull
     */
    private $active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = strtoupper($name);

        return $this;
    }

    public function getSubscriberBoxOut(): ?int
    {
        return $this->subscriberBoxOut;
    }

    public function setSubscriberBoxOut(int $subscriberBoxOut): self
    {
        $this->subscriberBoxOut = $subscriberBoxOut;

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

    public function getSubscriberBoxExt(): ?SubscriberBoxExt
    {
        return $this->subscriberBoxExt;
    }

    public function setSubscriberBoxExt(?SubscriberBoxExt $subscriberBoxExt): self
    {
        $this->subscriberBoxExt = $subscriberBoxExt;

        return $this;
    }
    
    public function __toString() {
        return '('. $this->code. ') '. $this->name;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
