<?php

namespace App\Entity;

use App\Repository\CurrencyPairRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyPairRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class CurrencyPair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Currency::class, inversedBy: 'currencyPairsFrom')]
    private Collection $currencyFrom;

    #[ORM\ManyToMany(targetEntity: Currency::class, inversedBy: 'currencyPairsTo')]
    private Collection $currencyTo;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->currencyFrom = new ArrayCollection();
        $this->currencyTo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Currency>
     */
    public function getCurrencyFrom(): Collection
    {
        return $this->currencyFrom;
    }

    public function addCurrencyFrom(Currency $currencyFrom): static
    {
        if (!$this->currencyFrom->contains($currencyFrom)) {
            $this->currencyFrom->add($currencyFrom);
        }

        return $this;
    }

    public function removeCurrencyFrom(Currency $currencyFrom): static
    {
        $this->currencyFrom->removeElement($currencyFrom);

        return $this;
    }

    /**
     * @return Collection<int, Currency>
     */
    public function getCurrencyTo(): Collection
    {
        return $this->currencyTo;
    }

    public function addCurrencyTo(Currency $currencyTo): static
    {
        if (!$this->currencyTo->contains($currencyTo)) {
            $this->currencyTo->add($currencyTo);
        }

        return $this;
    }

    public function removeCurrencyTo(Currency $currencyTo): static
    {
        $this->currencyTo->removeElement($currencyTo);

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
