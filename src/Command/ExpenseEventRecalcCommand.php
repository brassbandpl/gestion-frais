<?php

namespace App\Command;

use App\Repository\ExpenseEventRepository;
use App\Service\ExpenseEventCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExpenseEventRecalcCommand extends Command
{
    protected static $defaultName = 'app:expense-event:recalc';
    protected static $defaultDescription = 'Recalculate amount of expense events';

    private EntityManagerInterface $em;

    private ExpenseEventRepository $expenseEventRepository;

    private ExpenseEventCalculator $expenseEventCalculator;

    public function __construct(
        EntityManagerInterface $em,
        ExpenseEventRepository $expenseEventRepository, 
        ExpenseEventCalculator $expenseEventCalculator
    ) {
        parent::__construct();
        $this->em = $em;
        $this->expenseEventRepository = $expenseEventRepository;
        $this->expenseEventCalculator = $expenseEventCalculator;
    }

    protected function configure(): void
    {
        $this
            ->addOption('withClosedEvents', null, InputOption::VALUE_NONE, 'Recalculate all expense events, closed events included')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $qb = $this->expenseEventRepository->createQueryBuilder('exp');

        if (!$input->getOption('withClosedEvents')) {
            $qb->join('exp.event', 'ev');
            $qb->andWhere('ev.closed = 0');
        }

        $expenseEvents = $qb->getQuery()->getResult();

        foreach($expenseEvents as $expenseEvent) {
            $this->expenseEventCalculator->calculateRefund($expenseEvent);
        }

        $this->em->flush();

        $io->success(sprintf('%d expense events recalculated', count($expenseEvents)));

        return Command::SUCCESS;
    }
}
