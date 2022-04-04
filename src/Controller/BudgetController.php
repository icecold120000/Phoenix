<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Project;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
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
                'Votre fait a été sauvegardé !'
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
                'SuccessFact',
                'Votre budget a été modifié !'
            );

            return $this->redirectToRoute('app_budget_edit', ['id' => $budget->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('budget/edit.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/{projectId}', name: 'app_budget_delete', methods: ['POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function delete(Request $request, Budget $budget,
                           EntityManagerInterface $entityManager,
                           Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) {
            $entityManager->remove($budget);
            $entityManager->flush();
            $this->addFlash(
                'SuccessDeleteBudget',
                'Votre budget a été supprimé !'
            );
        }

        return $this->redirectToRoute('app_project_show', ['projectId' => $project->getId()], Response::HTTP_SEE_OTHER);
    }
}
