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
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $refundKmGo;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $refundKmReturn;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $refundTollGo;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $refundTollReturn;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $paied;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="expenseEvents")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->refundKmGo = 0;
        $this->refundKmReturn = 0;
        $this->refundTollGo = 0;
        $this->refundTollReturn = 0;
        $this->paied = false;
    }

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

    public function getRefundKmGo(): ?float
    {
        return $this->refundKmGo;
    }

    public function setRefundKmGo(?float $refundKmGo): self
    {
        $this->refundKmGo = $refundKmGo;

        return $this;
    }

    public function getRefundKmReturn(): ?float
    {
        return $this->refundKmReturn;
    }

    public function setRefundKmReturn(?float $refundKmReturn): self
    {
        $this->refundKmReturn = $refundKmReturn;

        return $this;
    }

    public function getRefundTollGo(): ?float
    {
        return $this->refundTollGo;
    }

    public function setRefundTollGo(?float $refundTollGo): self
    {
        $this->refundTollGo = $refundTollGo;

        return $this;
    }

    public function getRefundTollReturn(): ?float
    {
        return $this->refundTollReturn;
    }

    public function setRefundTollReturn(?float $refundTollReturn): self
    {
        $this->refundTollReturn = $refundTollReturn;

        return $this;
    }

    public function getTotalRefund(): ?float
    {
        return $this->getRefundKmGo() + $this->getRefundKmReturn() + $this->getRefundTollGo() + $this->getRefundTollReturn();
    }

    public function setPaied(bool $paied): self
    {
        $this->paied = $paied;

        return $this;
    }

    public function getPaied(): bool
    {
        return $this->paied;
    }
}
