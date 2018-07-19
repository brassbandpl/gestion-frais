<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->redirectToRoute('security_login');
    }
 
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(EntityManagerInterface $entityManager)
    {
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('admin.html.twig', ['events' => $events]);
    }
}
