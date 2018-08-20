<?php

namespace App\Controller;

use App\Entity\ExpenseEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ExpenseEventController extends Controller
{
    /**
     * @Route("/expenseEvent/list", name="expenseEvent_list")
     */
    public function list(EntityManagerInterface $entityManager, Security $security)
    {
        $user = $security->getUser();
        $expenseEvents = $entityManager->getRepository(ExpenseEvent::class)->findByUser($user);
        
        return $this->render('expenseEvent/list.html.twig', ['expenseEvents' => $expenseEvents]);
    }
}