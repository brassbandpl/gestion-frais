<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    const TYPE_REPETITION = 'repetition';
    const TYPE_CONCERT = 'concert';
    const TYPE_REUNION = 'reunion';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTimeStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTimeEnd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAllDay = false;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $addressLabel;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private $closed;

     /**
      * @ORM\OneToMany(targetEntity="ExpenseEvent", mappedBy="event")
      */
    private $expenseEvents;

    /**
     * @ORM\ManyToOne(targetEntity="Period", inversedBy="events")
     * @ORM\JoinColumn(name="period_id", referencedColumnName="id", nullable=false)
     */
    private $period;

    public function __construct()
    {
        $this->expenseEvents = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateTimeStart(): ?\DateTimeInterface
    {
        return $this->dateTimeStart;
    }

    public function setDateTimeStart(\DateTimeInterface $dateTimeStart): self
    {
        $this->dateTimeStart = $dateTimeStart;

        return $this;
    }

    public function getDateTimeEnd(): ?\DateTimeInterface
    {
        return $this->dateTimeEnd;
    }

    public function setDateTimeEnd(?\DateTimeInterface $dateTimeEnd): self
    {
        $this->dateTimeEnd = $dateTimeEnd;

        return $this;
    }

    public function isAllDay(): bool
    {
        return $this->isAllDay;
    }

    public function setIsAllDay(bool $isAllDay): self
    {
        $this->isAllDay = $isAllDay;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isDeclarable(): bool
    {
        return $this->dateTimeStart < new \DateTime();
    }

    public function getAddressLabel(): ?string
    {
        return $this->addressLabel;
    }

    public function setAddressLabel(string $addressLabel): self
    {
        $this->addressLabel = $addressLabel;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

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
     * @return Collection|ExpenseEvent[]
     */
    public function getExpenseEvents(): Collection
    {
        return $this->expenseEvents;
    }

    public function addExpenseEvent(ExpenseEvent $expenseEvent): self
    {
        if (!$this->expenseEvents->contains($expenseEvent)) {
            $this->expenseEvents[] = $expenseEvent;
            $expenseEvent->setEvent($this);
        }

        return $this;
    }

    public function removeExpenseEvent(ExpenseEvent $expenseEvent): self
    {
        if ($this->expenseEvents->contains($expenseEvent)) {
            $this->expenseEvents->removeElement($expenseEvent);
            // set the owning side to null (unless already changed)
            if ($expenseEvent->getEvent() === $this) {
                $expenseEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function getExpenseEventsByUser($user)
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('user', $user));

        return $this->expenseEvents->matching($criteria);
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    public function setPeriod(?Period $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function __toString()
    {
        return $this->getType().' - '.$this->getDateTimeStart()->format('Y-m-d');
    }
}
