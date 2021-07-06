<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(): Response
    {
        $items = [];

        if ($_ENV["DATABASE_URL"]) {
            $repo = $this->getDoctrine()->getRepository(Item::class);
            $items = $repo->findBy([
                "parent" => null,
                "done" => false
            ]);
        }

        return $this->render('index.twig', [
            "title" => "Home",
            "navItems" => [],
            "items" => $items,
            "component" => "components/home.twig"
        ]);
    }

    /**
     * @Route("/", name="process", methods={"POST"})
     */
    public function process(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Item::class);
        $item = $repo->find($request->get("id"));
        $item->setDone(true);

        $manager->persist($item);
        $manager->flush();
        return $this->redirectToRoute("home");
    }
}
