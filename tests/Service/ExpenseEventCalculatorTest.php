<?php
namespace App\Tests\Service;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Service\ExpenseEventCalculator;
use PHPUnit\Framework\TestCase;

class ExpenseEventCalculatorTest extends TestCase
{
    /**
     * @dataProvider getExpenseEvent
     */
    public function testCalculateRefund($expenseEvent, $refundKmGo, $refundKmReturn, $refundTollGo, $refundTollReturn) {
        $expenseEventCalculator = new ExpenseEventCalculator(0.5, true, false, 10);
        $expenseEventCalculator->calculateRefund($expenseEvent);

        $this->assertSame($refundKmGo, $expenseEvent->getRefundKmGo());
        $this->assertSame($refundKmReturn, $expenseEvent->getRefundKmReturn());
        $this->assertSame($refundTollGo, $expenseEvent->getRefundTollGo());
        $this->assertSame($refundTollReturn, $expenseEvent->getRefundTollReturn());
    }

    public function getExpenseEvent ()
    {
        $event = new Event();
        $event->setType(Event::TYPE_REPETITION);

        $expenseEvent = new ExpenseEvent();
        $expenseEvent->setEvent($event);
        $expenseEvent->setNbKmGo(10);
        $expenseEvent->setNbKmReturn(15);
        $expenseEvent->setTollGo(6);
        $expenseEvent->setTollReturn(0);

        yield 'Répétition' => [
            $expenseEvent,
            0.0,
            2.5,
            6.0,
            0.0
        ];

        $expenseEvent = new ExpenseEvent();
        $expenseEvent->setEvent($event);
        $expenseEvent->setNbKmGo(10);
        $expenseEvent->setNbKmReturn(15);
        $expenseEvent->setTollGo(null);
        $expenseEvent->setTollReturn(null);

        yield 'Répétition sans péage' => [
            $expenseEvent,
            0.0,
            2.5,
            0.0,
            0.0
        ];

        $event = new Event();
        $event->setType(Event::TYPE_CONCERT);
        $expenseEvent = new ExpenseEvent();
        $expenseEvent->setEvent($event);
        $expenseEvent->setNbKmGo(10);
        $expenseEvent->setNbKmReturn(15);
        $expenseEvent->setTollGo(6);
        $expenseEvent->setTollReturn(0);

        yield 'Concert' => [
            $expenseEvent,
            5.0,
            7.5,
            6.0,
            0.0
        ];
    }
}