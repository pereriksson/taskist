<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Person;
use App\Entity\Project;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    /**
     * @Route("/add", name="add", methods={"GET"})
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $people = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Tag::class);
        $tags = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Project::class);
        $projects = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Item::class);
        $items = $repository->findBy([
            "done" => false
        ]);

        return $this->render('index.twig', [
            "title" => "Add a todo",
            "navItems" => [],
            "people" => $people,
            "tags" => $tags,
            "projects" => $projects,
            "items" => $items,
            "component" => "components/add.twig"
        ]);
    }

    /**
     * @Route("/add", name="add_process", methods={"POST"})
     */
    public function process(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $item = new Item();
        $item->setDone(false);
        $item->setTitle($request->get("title"));
        $item->setDescription($request->get("description"));

        if ($request->get("deadline")) {
            try {
                $item->setDeadline(new \DateTime($request->get("deadline")));
            } catch (\Exception $e) {
                // Date could not be parsed, ignore
            }
        }

        if ($request->get("project")) {
            $repo = $this->getDoctrine()->getRepository(Project::class);
            $project = $repo->find($request->get("project"));
            $item->setProject($project);
        }

        if ($request->get("responsible")) {
            $repo = $this->getDoctrine()->getRepository(Person::class);
            $responsible = $repo->find($request->get("responsible"));
            $item->setResponsible($responsible);
        }

        if ($request->get("parent")) {
            $repo = $this->getDoctrine()->getRepository(Item::class);
            $parent = $repo->find($request->get("parent"));
            $item->setParent($parent);
        }

        $repo = $this->getDoctrine()->getRepository(Tag::class);
        $tags = $request->get("tags");

        foreach ($tags as $tag) {
            $tag = $repo->find((int) $tag);
            $item->addTag($tag);
        }

        // Save
        if ($item->getTitle()) {
            $manager->persist($item);
            $manager->flush();
        }

        return $this->redirectToRoute("home");
    }
}
