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
use DateTime;

class AddController extends AbstractController
{
    private $item;

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
        $this->item = new Item();
        $this->item->setDone(false);
        $this->item->setTitle($request->get("title"));
        $this->item->setDescription($request->get("description"));

        if ($request->get("deadline")) {
            try {
                $this->item->setDeadline(new DateTime($request->get("deadline")));
            } catch (\Exception $e) {
                // Date could not be parsed, ignore
            }
        }

        if ($request->get("project")) {
            $repo = $this->getDoctrine()->getRepository(Project::class);
            $project = $repo->find($request->get("project"));
            $this->item->setProject($project);
        }

        if ($request->get("responsible")) {
            $repo = $this->getDoctrine()->getRepository(Person::class);
            $responsible = $repo->find($request->get("responsible"));
            $this->item->setResponsible($responsible);
        }

        if ($request->get("parent")) {
            $repo = $this->getDoctrine()->getRepository(Item::class);
            $parent = $repo->find($request->get("parent"));
            $this->item->setParent($parent);
        }

        $this->addTags($request);

        // Save
        if ($this->item->getTitle()) {
            $manager->persist($this->item);
            $manager->flush();
        }

        return $this->redirectToRoute("home");
    }

    private function addTags(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Tag::class);
        $tags = $request->get("tags");

        if ($tags and count($tags) > 0) {
            foreach ($tags as $tag) {
                $tag = $repo->find((int) $tag);
                $this->item->addTag($tag);
            }
        }
    }
}
