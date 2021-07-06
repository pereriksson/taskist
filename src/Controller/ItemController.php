<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Item;
use App\Entity\Person;
use App\Entity\Project;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class ItemController extends AbstractController
{
    private $item;

    /**
     * @Route("/item/{id}", name="item", methods={"GET"})
     */
    public function itemDetails(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $item = $repository->find($id);

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
