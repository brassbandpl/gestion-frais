<?php
namespace App\Service;

use App\Entity\Event;
use App\Entity\ExpenseEvent;

class ExpenseEventCalculator 
{
    private $euroPerKm;
    private $isTollGoRefunded;
    private $isTollReturnRefunded;
    private $nbKmNotRefund;

    public function __construct(float $euroPerKm, bool $isTollGoRefunded, bool $isTollReturnRefunded, int $nbKmNotRefund)
    {
        $this->euroPerKm = $euroPerKm;
        $this->isTollGoRefunded = $isTollGoRefunded;
        $this->isTollReturnRefunded = $isTollReturnRefunded;
        $this->nbKmNotRefund = $nbKmNotRefund;
    }

    public function calculateRefund(ExpenseEvent $expenseEvent): void
    {
        $refundKmGo = $expenseEvent->getNbKmGo() > 0 ? $this->euroPerKm * $expenseEvent->getNbKmGo() : 0;
        $refundKmReturn = $expenseEvent->getNbKmReturn() > 0 ? $this->euroPerKm * $expenseEvent->getNbKmReturn() : 0;
        $refundTollGo = $expenseEvent->getTollGo();
        $refundTollReturn = $expenseEvent->getTollReturn();

        if ($expenseEvent->getEvent()->getType() === Event::TYPE_REPETITION) {
            $refundKmGo = 0;
            if ($expenseEvent->getNbKmGo()-$this->nbKmNotRefund > 0) {
                $refundKmGo = $this->euroPerKm * ($expenseEvent->getNbKmGo()-$this->nbKmNotRefund);
            }
            $refundKmReturn = 0;
            if ($expenseEvent->getNbKmReturn()-$this->nbKmNotRefund > 0) {
                $refundKmReturn = $this->euroPerKm * ($expenseEvent->getNbKmReturn()-$this->nbKmNotRefund);
            }
            $refundTollGo = $this->isTollGoRefunded ? $expenseEvent->getTollGo() : 0;
            $refundTollReturn = $this->isTollReturnRefunded ? $expenseEvent->getTollReturn() : 0;
        }
        
        $expenseEvent->setRefundKmGo($refundKmGo);
        $expenseEvent->setRefundKmReturn($refundKmReturn);
        $expenseEvent->setRefundTollGo($refundTollGo);
        $expenseEvent->setRefundTollReturn($refundTollReturn);
    }
}