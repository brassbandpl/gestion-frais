<?php
namespace App\Service;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Entity\RefundConfiguration;
use App\Repository\RefundConfigurationRepository;

class ExpenseEventCalculator 
{
    private RefundConfigurationRepository $refundConfigurationRepository;

    public function __construct(RefundConfigurationRepository $refundConfigurationRepository)
    {
        $this->refundConfigurationRepository = $refundConfigurationRepository;
    }

    public function calculateRefund(ExpenseEvent $expenseEvent): void
    {
        $config = $this->refundConfigurationRepository->findOneForDate($expenseEvent->getEvent()->getDateTimeStart());
        $euroPerKm = $config->getEuroPerKm();
        $nbKmNotRefund = $config->getNbKmNotRefund();
        $isTollGoRefunded = $config->getIsTollGoRefunded();
        $isTollReturnRefunded = $config->getIsTollReturnRefunded();

        $refundKmGo = $expenseEvent->getNbKmGo() > 0 ? $euroPerKm * $expenseEvent->getNbKmGo() : 0;
        $refundKmReturn = $expenseEvent->getNbKmReturn() > 0 ? $euroPerKm * $expenseEvent->getNbKmReturn() : 0;
        $refundTollGo = $expenseEvent->getTollGo() ?? 0;
        $refundTollReturn = $expenseEvent->getTollReturn() ?? 0;

        if ($expenseEvent->getEvent()->getType() === Event::TYPE_REPETITION) {
            $refundKmGo = 0;
            if ($expenseEvent->getNbKmGo()-$nbKmNotRefund > 0) {
                $refundKmGo = $euroPerKm * ($expenseEvent->getNbKmGo()-$nbKmNotRefund);
            }
            $refundKmReturn = 0;
            if ($expenseEvent->getNbKmReturn()-$nbKmNotRefund > 0) {
                $refundKmReturn = $euroPerKm * ($expenseEvent->getNbKmReturn()-$nbKmNotRefund);
            }
            $refundTollGo = $isTollGoRefunded ? $refundTollGo : 0;
            $refundTollReturn = $isTollReturnRefunded ? $refundTollReturn : 0;
        }
        
        $expenseEvent->setRefundKmGo($refundKmGo);
        $expenseEvent->setRefundKmReturn($refundKmReturn);
        $expenseEvent->setRefundTollGo($refundTollGo);
        $expenseEvent->setRefundTollReturn($refundTollReturn);
    }
}