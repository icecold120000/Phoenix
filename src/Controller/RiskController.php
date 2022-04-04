<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Risk;
use App\Form\RiskType;
use App\Repository\RiskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/risk')]
class RiskController extends AbstractController
{
    #[Route('/new/{id}', name: 'app_risk_new', methods: ['GET', 'POST'])]
    /**
     * @Entity("project", expr="repository.find(id)")
     */
    public function new(Request $request, EntityManagerInterface $entityManager,
                        Project $project): Response
    {
        $risk = new Risk();
        $form = $this->createForm(RiskType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $risk->setProject($project);
            $project->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($project);
            $entityManager->persist($risk);
            $entityManager->flush();
            $this->addFlash(
                'SuccessRisk',
                'Votre risque a été ajouté !'
            );

            return $this->redirectToRoute('app_risk_new', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risk/new.html.twig', [
            'risk' => $risk,
            'form' => $form,
            'projectId' => $project->getId()
        ]);
    }

    #[Route('/{id}/edit/{projectId}', name: 'app_risk_edit', methods: ['GET', 'POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function edit(Request $request, Risk $risk, EntityManagerInterface $entityManager,
                         Project $project): Response
    {
        $form = $this->createForm(RiskType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash(
                'SuccessRisk',
                'Votre risque a été modifié !'
            );
            return $this->redirectToRoute('app_risk_index', ['id' => $risk->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risk/edit.html.twig', [
            'risk' => $risk,
            'form' => $form,
            'projectId' => $project->getId(),
        ]);
    }

    #[Route('/{projectId}/{id}', name: 'app_risk_delete', methods: ['POST'])]
    /**
     * @Entity("project", expr="repository.find(projectId)")
     */
    public function delete(Request $request, Risk $risk,
                           EntityManagerInterface $entityManager,
                           Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$risk->getId(), $request->request->get('_token'))) {
            $entityManager->remove($risk);
            $project->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash(
                'SuccessDeleteRisk',
                'Votre risque a été supprimé !'
            );
        }

        return $this->redirectToRoute('app_project_show', ['projectId' => $project->getId()], Response::HTTP_SEE_OTHER);
    }
}
