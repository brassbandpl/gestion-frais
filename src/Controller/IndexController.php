<?php

namespace App\Controller;

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
    public function admin()
    {
        return $this->render('admin.html.twig');
    }
}
