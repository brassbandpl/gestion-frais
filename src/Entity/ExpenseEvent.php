<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpenseEventRepository")
 */
class ExpenseEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbKmGo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbKmReturn;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tollGo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tollReturn;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="expenseEvents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getNbKmGo(): ?int
    {
        return $this->nbKmGo;
    }

    public function setNbKmGo(?int $nbKmGo): self
    {
        $this->nbKmGo = $nbKmGo;

        return $this;
    }

    public function getNbKmReturn(): ?int
    {
        return $this->nbKmReturn;
    }

    public function setNbKmReturn(int $nbKmReturn): self
    {
        $this->nbKmReturn = $nbKmReturn;

        return $this;
    }

    public function getTollGo(): ?float
    {
        return $this->tollGo;
    }

    public function setTollGo(?float $tollGo): self
    {
        $this->tollGo = $tollGo;

        return $this;
    }

    public function getTollReturn(): ?float
    {
        return $this->tollReturn;
    }

    public function setTollReturn(?float $tollReturn): self
    {
        $this->tollReturn = $tollReturn;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
