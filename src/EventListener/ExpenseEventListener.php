<?php
namespace App\EventListener;

use App\Entity\ExpenseEvent;
use App\Service\ExpenseEventCalculator;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ExpenseEventListener
{
    /** @var ExpenseEventCalculator $expenseEventCalculator */
    private $expenseEventCalculator;

    public function __construct(ExpenseEventCalculator $expenseEventCalculator)
    {
        $this->expenseEventCalculator = $expenseEventCalculator;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof ExpenseEvent) {
            return;
        }
        $this->expenseEventCalculator->calculateRefund($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof ExpenseEvent) {
            return;
        }
        $this->expenseEventCalculator->calculateRefund($entity);
    }
}