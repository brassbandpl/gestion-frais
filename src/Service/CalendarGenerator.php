<?php
namespace App\Service;

use App\Entity\Event as EntityEvent;
use App\Repository\EventRepository;
use DateInterval;
use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CalendarGenerator
{
    /** @var EventRepository */
    private $eventRepository;

    /** @var ParameterBagInterface */
    private $parameterBag;

    public function __construct(EventRepository $eventRepository, ParameterBagInterface $parameterBag)
    {
        $this->eventRepository = $eventRepository;
        $this->parameterBag = $parameterBag;
    }

    public function generate(string $fileName = null): void
    {
        $eventSinceDate = (new DateTimeImmutable())->sub(new DateInterval('P6M'));
        $databaseEvents = $this->eventRepository->findBySinceDate($eventSinceDate);
        $events = [];
        foreach($databaseEvents as $event) {
            $summary = '';
            $date = $event->getDate();
            switch ($event->getType()) {
                case EntityEvent::TYPE_REPETITION:
                    $summary = 'BBPL - Répétition';
                    $dateBegin = new DateTimeImmutable($date->format('Y-m-d 20:30'));
                    $dateEnd = new DateTimeImmutable($date->format('Y-m-d 22:30'));
                    $occurence = new TimeSpan(new DateTime($dateBegin, true), new DateTime($dateEnd, true));
                    break;
                case EntityEvent::TYPE_CONCERT:
                    $summary = 'BBPL - Concert';
                    $occurence = new SingleDay(new Date($date));
                    break;
                default:
                    continue;
            }
            $events[] = (new Event())
                ->setSummary($summary)
                ->setLocation(new Location($event->getAddress().' '.$event->getPostalCode().' '.$event->getCity(), $event->getAddressLabel()))
                ->setOccurrence($occurence)
            ;    
        }

        $calendar = new Calendar($events);
        $icalComponent = (new CalendarFactory())->createCalendar($calendar);

        file_put_contents(sprintf('%s/public/%s', $this->parameterBag->get('kernel.project_dir'), $fileName ?? 'calendar.ics'), (string) $icalComponent);
    }
}
