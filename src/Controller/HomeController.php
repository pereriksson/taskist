<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Item::class);
        $items = $repo->findBy([
            "parent" => null
        ]);

        return $this->render('index.twig', [
            "title" => "Home",
            "navItems" => [],
            "items" => $items,
            "component" => "components/home.twig"
        ]);
    }
}
