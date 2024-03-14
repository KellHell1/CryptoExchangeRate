<?php

namespace App\Entity;

use App\Repository\CurrencyPairRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyPairRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CurrencyPair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'currencyPairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currencyFrom = null;

    #[ORM\ManyToOne(inversedBy: 'currencyPairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currencyTo = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyFrom(): ?Currency
    {
        return $this->currencyFrom;
    }

    public function setCurrencyFrom(?Currency $currencyFrom): static
    {
        $this->currencyFrom = $currencyFrom;

        return $this;
    }

    public function getCurrencyTo(): ?Currency
    {
        return $this->currencyTo;
    }

    public function setCurrencyTo(?Currency $currencyTo): static
    {
        $this->currencyTo = $currencyTo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime("now");
    }
}
