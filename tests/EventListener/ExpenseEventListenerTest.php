<?php
namespace App\Tests\EventListener;

use App\Entity\ExpenseEvent;
use App\EventListener\ExpenseEventListener;
use App\Service\ExpenseEventCalculator;
use PHPUnit\Framework\TestCase;

class ExpenseEventListenerTest extends TestCase
{
    public function testPrePersist() {
        $expenseEvent = new ExpenseEvent();

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $expenseEventCalculator = $this->mockExpenseEventCalculator();

        $lifeCycleEvent->expects($this->once())->method('getObject')->willReturn($expenseEvent);
        $expenseEventCalculator->expects($this->once())->method('calculateRefund');

        $listener = new ExpenseEventListener($expenseEventCalculator);
        $listener->prePersist($lifeCycleEvent);
    }

    public function testPreUpdate() {
        $expenseEvent = new ExpenseEvent();

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $expenseEventCalculator = $this->mockExpenseEventCalculator();

        $lifeCycleEvent->expects($this->once())->method('getObject')->willReturn($expenseEvent);
        $expenseEventCalculator->expects($this->once())->method('calculateRefund');

        $listener = new ExpenseEventListener($expenseEventCalculator);
        $listener->prePersist($lifeCycleEvent);
    }

    private function mockExpenseEventCalculator()
    {
        $lifeCycleEvent = $this->createMock(
            ExpenseEventCalculator::class,
            ['calculateRefund'],
            [],
            '',
            false
        );

        return $lifeCycleEvent;
    }

    private function mockEvent($eventType)
    {
        $lifeCycleEvent = $this->createMock(
            '\Doctrine\ORM\Event\\'.$eventType,
            ['getObject'],
            [],
            '',
            false
        );

        return $lifeCycleEvent;
    }
}