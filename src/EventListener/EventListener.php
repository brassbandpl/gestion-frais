<?php
namespace App\EventListener;

use App\Entity\Event;
use App\Service\CalendarGenerator;;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class EventListener
{

    /** @var boolean */
    private $hasChanged;

    /** @var CalendarGenerator */
    private $calendarGenerator;

    public function __construct(CalendarGenerator $calendarGenerator)
    {
        $this->calendarGenerator = $calendarGenerator;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Event) {
            return;
        }
        $this->hasChanged = true;
    }
    
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Event) {
            return;
        }
        $this->hasChanged = true;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Event) {
            return;
        }
        $this->hasChanged = true;
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if ($this->hasChanged === false) {
            return;
        }
        $this->calendarGenerator->generate();
    }
}