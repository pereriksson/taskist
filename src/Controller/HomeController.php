<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function number(): Response
    {
        return $this->render('index.twig', [
            "title" => "Home",
            "navItems" => [],
            "component" => "components/home.twig"
        ]);
    }
}
