<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'currencyFrom', targetEntity: CurrencyPare::class, orphanRemoval: true)]
    private Collection $currencyPares;

    public function __construct()
    {
        $this->currencyPares = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
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

    /**
     * @return Collection<int, CurrencyPare>
     */
    public function getCurrencyPares(): Collection
    {
        return $this->currencyPares;
    }

    public function addCurrencyPare(CurrencyPare $currencyPare): static
    {
        if (!$this->currencyPares->contains($currencyPare)) {
            $this->currencyPares->add($currencyPare);
            $currencyPare->setCurrencyFrom($this);
        }

        return $this;
    }

    public function removeCurrencyPare(CurrencyPare $currencyPare): static
    {
        if ($this->currencyPares->removeElement($currencyPare)) {
            // set the owning side to null (unless already changed)
            if ($currencyPare->getCurrencyFrom() === $this) {
                $currencyPare->setCurrencyFrom(null);
            }
        }

        return $this;
    }
}
