<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function number(): Response
    {
        return $this->render('index.twig', [
            "title" => "Home",
            "navItems" => [],
            "component" => "components/add.twig"
        ]);
    }
}
