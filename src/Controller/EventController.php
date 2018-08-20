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
    public function __construct($euroPerKm, $isTollGoRefunded, $isTollReturnRefunded, $nbKmNotRefund) 
    {
        $this->euroPerKm = $euroPerKm;
        $this->isTollGoRefunded = $isTollGoRefunded;
        $this->isTollReturnRefunded = $isTollReturnRefunded;
        $this->nbKmNotRefund = $nbKmNotRefund;
    }

    /**
     * @Route("/event/list", name="event_list")
     */
    public function list(EntityManagerInterface $entityManager, Security $security)
    {
        $user = $security->getUser();
        $events = $entityManager->getRepository(Event::class)->findAll();
        
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
            $expenseEvent->setRefundKmGo(0);
            $expenseEvent->setRefundKmReturn(0);
            if ($expenseEvent->getNbKmGo()-$this->nbKmNotRefund > 0) {
                $expenseEvent->setRefundKmGo($this->euroPerKm * ($expenseEvent->getNbKmGo()-$this->nbKmNotRefund));
            }
            if ($expenseEvent->getNbKmReturn()-$this->nbKmNotRefund > 0) {
                $expenseEvent->setRefundKmReturn($this->euroPerKm * ($expenseEvent->getNbKmReturn()-$this->nbKmNotRefund));
            }
            $expenseEvent->setRefundTollGo($this->isTollGoRefunded ? $expenseEvent->getTollGo() : 0);
            $expenseEvent->setRefundTollReturn($this->isTollReturnRefunded ? $expenseEvent->getTollGo() : 0);
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