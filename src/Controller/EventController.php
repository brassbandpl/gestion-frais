<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Entity\User;
use App\Form\ExpenseEventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EventController extends AbstractController
{
    /**
     * @Route("/event/list", name="event_list")
     */
    public function list(EntityManagerInterface $entityManager, Security $security)
    {
        /** @var User $user */
        $user = $security->getUser();
        /** @var EventRepository $eventRepo */
        $eventRepo = $entityManager->getRepository(Event::class);
        $events = $eventRepo->findByNotClosedAndBetweenDates($user->getDateBegin(), $user->getDateEnd());
        
        return $this->render('event/list.html.twig', ['events' => $events, 'user' => $user]);
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