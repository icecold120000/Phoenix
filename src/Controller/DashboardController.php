<?php

namespace App\Controller;

use App\DataFixtures\StatusFixtures;
use App\Repository\FactRepository;
use App\Repository\MilestoneRepository;
use App\Repository\ProjectRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/dashboard', name: 'app_dashboard_index')]
    public function index(FactRepository $factRepo, ProjectRepository $projectRepo,
                          StatusRepository $statusRepo): Response
    {
        $user = $this->getUser();
        $projects = array_merge($projectRepo->findByTeamClient($user->getId()),$projectRepo->findByProdTeam($user->getId()));
        return $this->render('dashboard/index.html.twig', [
            'milestonesObtained' => $factRepo->findAllVerified(true),
            'factsNotConfirmed' => $factRepo->findAllVerified(),
            'lastUpdatedProjects' => $projectRepo->findLastUpdatedProjects(),
            'myProjects' => $projects,
            'statuses' => $statusRepo->findAll()
        ]);
    }
}
