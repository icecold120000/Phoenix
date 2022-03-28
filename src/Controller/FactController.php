<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Entity\Project;
use App\Form\FactType;
use App\Repository\FactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fact')]
class FactController extends AbstractController
{
    #[Route('/new/{id}', name: 'fact_new', methods: ['GET', 'POST'])]
    /**
     * @Entity("project", expr="repository.find(id)")
     */
    public function new(Request $request, EntityManagerInterface $entityManager,
                        Project $project): Response
    {
        $fact = new Fact();
        $form = $this->createForm(FactType::class, $fact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fact->setProject($project);
            $entityManager->persist($fact);
            $entityManager->flush();
            $this->addFlash(
                'SuccessFact',
                'Votre fait a été ajouté !'
            );

            return $this->redirectToRoute('fact_new', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fact/new.html.twig', [
            'fact' => $fact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'fact_show', methods: ['GET'])]
    public function show(Fact $fact): Response
    {
        return $this->render('fact/show.html.twig', [
            'fact' => $fact,
        ]);
    }

    #[Route('/validate/{id}', name: 'validate_fact', methods: ['GET','POST'])]
    public function validateFact(Fact $fact, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($fact->getIsValidated() === false) {
            $fact->setIsValidated(true);
        }
        else {
            $fact->setIsValidated(false);
        }
        $entityManager->persist($fact);
        $entityManager->flush();

        return $this->redirectToRoute('fact_show', ['id' => $fact->getId()], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}/edit/{projectId}', name: 'fact_edit', methods: ['GET', 'POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function edit(Request $request, Fact $fact,
                         EntityManagerInterface $entityManager,
                         Project $project): Response
    {
        $form = $this->createForm(FactType::class, $fact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'SuccessFact',
                'Votre fait a été modifié !'
            );

            return $this->redirectToRoute('fact_edit', ['id' => $fact->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fact/edit.html.twig', [
            'fact' => $fact,
            'form' => $form,
            'projectId' => $project->getId(),
        ]);
    }

    #[Route('/{id}', name: 'fact_delete', methods: ['POST'])]
    public function delete(Request $request, Fact $fact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }
}