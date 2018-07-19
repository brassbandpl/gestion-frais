<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends Controller
{
    /**
     * @Route("/event/list", name="event_list")
     */
    public function admin(EntityManagerInterface $entityManager)
    {
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('event/list.html.twig', ['events' => $events]);
    }
}