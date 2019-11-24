<?php

namespace App\Controller;

use App\Entity\ExpenseEvent;
use App\Entity\Period;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ExpenseEventController extends AbstractController
{
    /**
     * @Route("/expenseEvent/list/{period?}", name="expenseEvent_list")
     */
    public function list(EntityManagerInterface $entityManager, Security $security, ?Period $period)
    {
        /** @var User $user */
        $user = $security->getUser();

        $periods = $entityManager->getRepository(Period::class)->findByDates($user->getDateBegin(), $user->getDateEnd());
        if (!isset($period) && isset($periods)) {
            $period = $periods[0];
        }

        $expenseEvents = $entityManager->getRepository(ExpenseEvent::class)->findByUserAndPeriod($user, $period);

        return $this->render(
            'expenseEvent/list.html.twig', 
            [
                'expenseEvents' => $expenseEvents, 
                'periods' => $periods,
                'periodSelected' => $period
            ]
        );
    }
}