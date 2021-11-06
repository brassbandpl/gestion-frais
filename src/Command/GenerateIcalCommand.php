<?php

namespace App\Command;

use App\Entity\Event as EntityEvent;
use App\Repository\EventRepository;
use App\Service\CalendarGenerator;
use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateIcalCommand extends Command
{
    protected static $defaultName = 'app:generate-ical';
    protected static $defaultDescription = 'Generate icalFile';

    /** @var CalendarGenerator */
    private $calendarGenerator;

    public function __construct(CalendarGenerator $calendarGenerator)
    {
        parent::__construct();
        $this->calendarGenerator = $calendarGenerator;
    }
    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $this->calendarGenerator->generate();
        
        $io->success('iCal generated.');

        return Command::SUCCESS;
    }
}
