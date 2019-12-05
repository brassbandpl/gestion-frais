<?php
namespace App\Tests\Service;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Service\ExpenseEventCalculator;
use PHPUnit\Framework\TestCase;

class ExpenseEventCalculatorTest extends TestCase
{
    public function testCalculateRefundConcert() {
        $event = new Event();
        $event->setType(Event::TYPE_CONCERT);
        $expenseEvent = new ExpenseEvent();
        $expenseEvent->setEvent($event);
        $expenseEvent->setNbKmGo(10);
        $expenseEvent->setNbKmReturn(15);
        $expenseEvent->setTollGo(6);
        $expenseEvent->setTollReturn(0);

        $expenseEventCalculator = new ExpenseEventCalculator(0.5, true, false, 10);
        $expenseEventCalculator->calculateRefund($expenseEvent);

        $this->assertEquals(5, $expenseEvent->getRefundKmGo());
        $this->assertEquals(7.5, $expenseEvent->getRefundKmReturn());
        $this->assertEquals(6, $expenseEvent->getRefundTollGo());
        $this->assertEquals(0, $expenseEvent->getRefundTollReturn());
    }

    public function testCalculateRefundRepetition() {
        $event = new Event();
        $event->setType(Event::TYPE_REPETITION);
        $expenseEvent = new ExpenseEvent();
        $expenseEvent->setEvent($event);
        $expenseEvent->setNbKmGo(10);
        $expenseEvent->setNbKmReturn(15);
        $expenseEvent->setTollGo(6);
        $expenseEvent->setTollReturn(0);

        $expenseEventCalculator = new ExpenseEventCalculator(0.5, true, false, 10);
        $expenseEventCalculator->calculateRefund($expenseEvent);

        $this->assertEquals(0, $expenseEvent->getRefundKmGo());
        $this->assertEquals(2.5, $expenseEvent->getRefundKmReturn());
        $this->assertEquals(6, $expenseEvent->getRefundTollGo());
        $this->assertEquals(0, $expenseEvent->getRefundTollReturn());
    }
}