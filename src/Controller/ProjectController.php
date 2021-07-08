<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\Project;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/{projectId}", name="project", methods={"GET"})
     */
    public function projectDetails(int $projectId): Response
    {
        $repo = $this->getDoctrine()->getRepository(Project::class);
        $project = $repo->find($projectId);

        $repo = $this->getDoctrine()->getRepository(Item::class);
        $items = $repo->findBy([
            "parent" => null,
            "project" => $project,
            "done" => false
        ]);

        return $this->render('index.twig', [
            "title" => "Project",
            "navItems" => [],
            "project" => $project,
            "items" => $items,
            "component" => "components/project.twig"
        ]);
    }

    /**
     * @Route("/project/{projectId}", name="process", methods={"POST"})
     */
    public function process(Request $request, int $projectId): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Item::class);
        $item = $repo->find($request->get("id"));
        $item->setDone(true);

        $manager->persist($item);
        $manager->flush();
        return $this->redirectToRoute("project", ["projectId" => $projectId]);
    }
}
