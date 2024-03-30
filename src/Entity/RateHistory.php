<?php

namespace App\Entity;

use App\Repository\RateHistoryRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateHistoryRepository::class)]
class RateHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'rateHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private CurrencyPair $currencyPair;

    #[ORM\Column]
    private float $rate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $datetime;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrencyPair(): CurrencyPair
    {
        return $this->currencyPair;
    }

    public function setCurrencyPair(CurrencyPair $currencyPair): self
    {
        $this->currencyPair = $currencyPair;

        return $this;
    }

    public function getRate(): float
    {
        return (float)$this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDatetime(): DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
}
