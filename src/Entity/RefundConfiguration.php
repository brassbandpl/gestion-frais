<?php

namespace App\Entity;

use App\Repository\RefundConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=RefundConfigurationRepository::class)
 */
class RefundConfiguration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeImmutable $dateStart;

    /**
     * @ORM\Column(type="integer")
     */
    private int $nbKmNotRefund;

    /**
     * @ORM\Column(type="float")
     */
    private float $euroPerKm;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isTollGoRefunded;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isTollReturnRefunded;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeImmutable $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getNbKmNotRefund(): int
    {
        return $this->nbKmNotRefund;
    }

    public function setNbKmNotRefund(int $nbKmNotRefund): self
    {
        $this->nbKmNotRefund = $nbKmNotRefund;

        return $this;
    }

    public function getEuroPerKm(): float
    {
        return $this->euroPerKm;
    }

    public function setEuroPerKm(float $euroPerKm): self
    {
        $this->euroPerKm = $euroPerKm;

        return $this;
    }

    public function getIsTollGoRefunded(): bool
    {
        return $this->isTollGoRefunded;
    }

    public function setIsTollGoRefunded(bool $isTollGoRefunded): self
    {
        $this->isTollGoRefunded = $isTollGoRefunded;

        return $this;
    }

    public function getIsTollReturnRefunded(): bool
    {
        return $this->isTollReturnRefunded;
    }

    public function setIsTollReturnRefunded(bool $isTollReturnRefunded): self
    {
        $this->isTollReturnRefunded = $isTollReturnRefunded;

        return $this;
    }
}
