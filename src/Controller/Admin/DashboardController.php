<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\ExpenseEvent;
use App\Entity\Period;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        /*$routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(EventCrudController::class)->generateUrl());*/

        // you can also redirect to different pages depending on the current user
        /*if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }*/

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        
        /** @var ExpenseEventRepository $expenseEventRepository */
        $expenseEventRepository = $this->em->getRepository(ExpenseEvent::class);
        $expenseEventTotals = $expenseEventRepository->findNotPaidTotolRefundsGroupByUser();;

        return $this->render(
            'admin/summary-to-pay.html.twig',
            [
                'expenseEventTotals' => $expenseEventTotals
            ]
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EasyAdmin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss')
            ->setTimeFormat('HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard');
        yield MenuItem::linkToCrud('ExpenseEvent', 'fas fa-folder-open', ExpenseEvent::class);
        yield MenuItem::linkToCrud('Event', 'fas fa-folder-open', Event::class);
        yield MenuItem::linkToCrud('Period', 'fas fa-folder-open', Period::class);
        yield MenuItem::linkToCrud('User', 'fas fa-folder-open', User::class);
        yield MenuItem::linktoRoute('Back to app', 'fas fa-folder-open', 'event_list');
    }
}
