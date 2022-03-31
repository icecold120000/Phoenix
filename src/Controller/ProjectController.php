<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\Filter\FilterProjectType;
use App\Form\ProjectType;
use App\Repository\FactRepository;
use App\Repository\ProjectRepository;
use App\Repository\RiskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
        $user = $this->getUser();
        if ($user != null && in_array("ROLE_ADMIN", $user->getRoles()) == false) {
            $projects = array_merge($projectRepository->findByTeamClient($user->getId()),
                $projectRepository->findByProdTeam($user->getId()));
        } else {
            $projects = $projectRepository->findAll();
        }

        $form = $this->createForm(FilterProjectType::class);
        $filter = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (in_array("ROLE_ADMIN", $user->getRoles()) == true) {
                $projects = $projectRepository->filterProject(
                    $filter->get('orderProject')->getData(),
                    $filter->get('searchProject')->getData(),
                    $filter->get('statusProject')->getData()
                );
            }
            else {
                $projects = $projectRepository->filterProject(
                    $filter->get('orderProject')->getData(),
                    $filter->get('searchProject')->getData(),
                    $filter->get('statusProject')->getData(),
                    $user->getId()
                );
            }

        }

        $projects = $paginator->paginate(
            $projects,
            $request->query->getInt('page',1),
            10
        );

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'formFilter' => $filter->createView(),
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
                         Request $request, Project $project): Response
    {
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
     * @Route("/project/{projectId}/show", name="app_project_show", methods={"GET"})
     * @Entity("project", expr="repository.find(projectId)")
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
     * @Route("/project/{id}", name="app_project_delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash(
                'SuccessDeleteProject',
                'Votre projet a été supprimé !'
            );
        }

        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }

}
