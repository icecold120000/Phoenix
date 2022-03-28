<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\Filter\FilterStatusType;
use App\Form\StatusType;
use App\Repository\ProjectRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/status")
 */
class StatusController extends AbstractController
{
    /**
     * @Route("/", name="status_index", methods={"GET","POST"})
     */
    public function index(StatusRepository $statusRepository,
                          PaginatorInterface $paginator,
                          Request $request): Response
    {
        $statuses = $statusRepository->findAll();

        $form = $this->createForm(FilterStatusType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $statuses = $statusRepository->filterStatus(
                $form->get('searchStatus')->getData()
            );
        }

        $statuses = $paginator->paginate(
            $statuses,
            $request->query->getInt('page',1),
            10
        );

        return $this->render('status/index.html.twig', [
            'statuses' => $statuses,
            'filterStatus' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="status_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($status);
            $entityManager->flush();
            $this->addFlash(
                'SuccessStatus',
                'Le statut a été sauvegardé !'
            );

            return $this->redirectToRoute('status_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/new.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="status_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Status $status, EntityManagerInterface $entityManager): Response
    {
        $oldColor = $status->getColorStatus();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('colorStatus')->getData() == "#000000") {
                $status->setColorStatus($oldColor);
            }

            $entityManager->flush();
            $this->addFlash(
                'SuccessStatus',
                'Le statut a été modifié !'
            );

            return $this->redirectToRoute('status_edit', ['id'=> $status->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/edit.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete_view", name="status_delete_view", methods={"GET","POST"})
     */
    public function delete_view(Status $status, ProjectRepository $projectRepo): Response
    {
        return $this->render('status/delete_view.html.twig', [
            'status' => $status,
            'projects' => $projectRepo->findByStatus($status->getId())
        ]);
    }

    /**
     * @Route("/{id}", name="status_delete", methods={"POST"})
     */
    public function delete(Request $request, Status $status, EntityManagerInterface $entityManager, ProjectRepository $projectRepo): Response
    {

        $projects = $projectRepo->findByStatus($status->getId());

        if ($projects != null) {
            $this->addFlash(
                'FailedDeleteStatus',
                'Erreur votre status est encore utilisé dans un ou plusieurs projet.
                Veuillez modifier les projets ci-dessous leur statut !'
            );
            return $this->redirectToRoute('status_delete_view',['id' => $status->getId()]);
        }
        else {
            if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
                $entityManager->remove($status);
                $entityManager->flush();
            }
            return $this->redirectToRoute('status_index', [], Response::HTTP_SEE_OTHER);
        }

    }
}
