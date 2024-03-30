<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[UniqueConstraint(name: "code", columns: ["code"])]
#[ORM\HasLifecycleCallbacks]
class Currency
{
    #[ORM\Column(length: 255)]
    private string $title;

    #[Id]
    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column]
    private DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'currencyFrom', targetEntity: CurrencyPair::class, orphanRemoval: true)]
    private Collection $currencyPairs;

    public function __construct()
    {
        $this->currencyPairs = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime("now");
    }

    /**
     * @return Collection<int, CurrencyPair>
     */
    public function getCurrencyPairs(): Collection
    {
        return $this->currencyPairs;
    }

    public function addCurrencyPair(CurrencyPair $currencyPair): static
    {
        if (!$this->currencyPairs->contains($currencyPair)) {
            $this->currencyPairs->add($currencyPair);
            $currencyPair->setCurrencyFrom($this);
        }

        return $this;
    }

    public function removeCurrencyPair(CurrencyPair $currencyPair): static
    {
        if ($this->currencyPairs->removeElement($currencyPair)) {
            // set the owning side to null (unless already changed)
            if ($currencyPair->getCurrencyFrom() === $this) {
                $currencyPair->setCurrencyFrom(null);
            }
        }

        return $this;
    }
}
