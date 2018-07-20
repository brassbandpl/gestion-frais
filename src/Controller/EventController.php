<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Form\ExpenseEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EventController extends Controller
{
    /**
     * @Route("/event/list", name="event_list")
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('event/list.html.twig', ['events' => $events]);
    }

    /**
     * @Route("/event/declare/{id}", methods={"GET","POST"}, name="event_declare")
     */
    public function declare($id, Request $request, EntityManagerInterface $entityManager, Security $security)
    {
        $event = $entityManager->getRepository(Event::class)->findOneById($id);
        $user = $security->getUser();
        $expenseEvent = $entityManager->getRepository(ExpenseEvent::class)->findOneBy([
            'event' => $event,
            'user' => $user,
        ]);

        if (!$expenseEvent) {
            $expenseEvent = new ExpenseEvent();
            $expenseEvent->setEvent($event);
            $expenseEvent->setUser($user);
        }

        $form = $this->createForm(ExpenseEventType::class, $expenseEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expenseEvent = $form->getData();
            $entityManager->persist($expenseEvent);
            $entityManager->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/declare.html.twig', [
            'event' => $event,
            'expenseEvent' => $expenseEvent,
            'form' => $form->createView(),
        ]);
    }
}