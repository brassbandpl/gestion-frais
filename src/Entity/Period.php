<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodRepository")
 */
class Period
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
      * @ORM\OneToMany(targetEntity="Event", mappedBy="period")
      */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection|Period[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Period $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setPeriod($this);
        }

        return $this;
    }

    public function removeEvent(Period $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getPeriod() === $this) {
                $event->setPeriod(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDateStart()->format('d/m/Y').' - '.$this->getDateEnd()->format('d/m/Y');
    }
}
