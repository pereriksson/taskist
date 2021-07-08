<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/item/{id}", name="item", methods={"GET"})
     */
    public function itemDetails(int $itemId): Response
    {
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $item = $repository->find($itemId);

        return $this->render('index.twig', [
            "title" => "Item",
            "navItems" => [],
            "item" => $item,
            "component" => "components/item.twig"
        ]);
    }

    /**
     * @Route("/item", name="add_comment", methods={"POST"})
     */
    public function process(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $item = $repository->find($request->get("id"));

        $comment = new Comment();
        $comment->setDescription($request->get("description"));
        $comment->setItem($item);

        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute("home");
    }
}
