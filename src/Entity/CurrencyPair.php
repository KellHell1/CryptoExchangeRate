<?php

namespace App\Entity;

use App\Repository\CurrencyPairRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: CurrencyPairRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CurrencyPair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'currencyPairsFrom')]
    #[JoinColumn(name: "currency_from_code", referencedColumnName: "code", nullable: false)]
    private Currency $currencyFrom;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'currencyPairsTo')]
    #[JoinColumn(name: "currency_to_code", referencedColumnName: "code", nullable: false)]
    private Currency $currencyTo;

    #[ORM\Column]
    private DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'currencyPair', targetEntity: RateHistory::class, orphanRemoval: true)]
    private Collection $rateHistories;

    public function __construct(
        Currency $currencyFrom,
        Currency $currencyTo,
    )
    {
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->rateHistories = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrencyFrom(): Currency
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): Currency
    {
        return $this->currencyTo;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
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
     * @return Collection<int, RateHistory>
     */
    public function getRateHistories(): Collection
    {
        return $this->rateHistories;
    }

    public function addRateHistory(RateHistory $rateHistory): self
    {
        if (!$this->rateHistories->contains($rateHistory)) {
            $this->rateHistories->add($rateHistory);
            $rateHistory->setCurrencyPair($this);
        }

        return $this;
    }
}
