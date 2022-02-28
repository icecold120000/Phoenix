<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\FactRepository;
use App\Repository\ProjectRepository;
use App\Repository\RiskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage", methods={"GET","POST"})
     */
    public function index(ProjectRepository $projectRepository,
                          PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAll();

        $projects = $paginator->paginate(
            $projects,
            $request->query->getInt('page',1),
            15
        );

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/new", name="app_new_project")
     */
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_show', ['project' => $project->getId()]);
        }

        return $this->render('project/new.html.twig', [
            'project_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{project}/show", name="app_project_show", methods={"GET"})
     */
    public function show(Project $project,
                         FactRepository $factRepo, RiskRepository $riskRepo): Response
    {
        return $this->render('project/show.html.twig',[
            'project' => $project,
            'facts' => $factRepo->findByProject($project->getId()),
            'risks' => $riskRepo->findByProject($project->getId()),
        ]);
    }

}