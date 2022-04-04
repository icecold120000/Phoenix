<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Project;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/budget')]
class BudgetController extends AbstractController
{
    #[Route('/new', name: 'app_budget_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $budget = new Budget();
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($budget);
            $entityManager->flush();
            $this->addFlash(
                'SuccessBudget',
                'Votre budget a été sauvegardé !'
            );
            return $this->redirectToRoute('app_budget_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('budget/new.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/{projectId}', name: 'app_budget_edit', methods: ['GET', 'POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function edit(Request $request, Budget $budget,
                         EntityManagerInterface $entityManager,
                         Project $project): Response
    {
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash(
                'SuccessBudget',
                'Votre budget a été modifié !'
            );

            return $this->redirectToRoute('app_budget_edit', ['id' => $budget->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('budget/edit.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete_view/{projectId}', name: 'app_budget_delete_view', methods: ['GET'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function delete_view(Budget $budget, Project $project): Response
    {
        return $this->render('budget/delete_view.html.twig', [
            'budget' => $budget,
            'project' => $project,
        ]);
    }

    #[Route('/{id}/{projectId}', name: 'app_budget_delete', methods: ['POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function delete(Request $request, Budget $budget,
                           EntityManagerInterface $entityManager,
                           Project $project, ProjectRepository $projectRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) {

            $projectsRelated = $projectRepo->findByBudget($budget->getId());

            if ($projectsRelated == null) {
                $entityManager->remove($budget);
                $entityManager->flush();
                $this->addFlash(
                    'SuccessDeleteBudget',
                    'Votre budget a été supprimé !'
                );
            }
            else {
                $this->addFlash(
                    'deleteDangerBudget',
                    'Erreur, impossible de supprimer ce budget.
                Veuillez vérifier que tous les projets ayant assignés ce budget soient changés.'
                );
                return $this->redirectToRoute('app_budget_delete_view',
                    ['id' => $budget->getId(),
                    'projectId' => $project->getId()])
                ;

            }
            return $this->redirectToRoute('app_project_show', ['projectId' => $project->getId()], Response::HTTP_SEE_OTHER);

        }

    }
}
