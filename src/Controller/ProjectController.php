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
     * @Route("/project/new", name="app_project_new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $project
                ->setCreatedAt(new \DateTime('now'))
                ->setUpdatedAt(new \DateTime('now'))
            ;

            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash(
                'SuccessProject',
                'Le projet a été sauvegardé !'
            );

            return $this->redirectToRoute('app_project_new', []);
        }

        return $this->render('project/new.html.twig', [
            'project_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/{id}/edit", name="app_project_edit", methods={"GET", "POST"})
     */
    public function edit(EntityManagerInterface $entityManager,
                         Request $request, Project $project) {
        $form = $this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project
                ->setUpdatedAt(new \DateTime('now'))
            ;
            $entityManager->flush();
            $this->addFlash(
                'SuccessProject',
                'Le projet a été modifié !'
            );

            return $this->redirectToRoute('app_project_edit',
                ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'project_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/{project}/show", name="app_project_show", methods={"GET"})
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

    /**
     * @Route("/project/{id}/delete_view", name="app_project_delete_view", methods={"GET","POST"})
     */
    public function delete_view(Project $project): Response
    {
        return $this->render('project/delete_view.html.twig', [
            'project' => $project,
        ]);
    }
    /**
     * @Route("/project/{id}", name="project_delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
    }

}
