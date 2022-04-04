<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function filterProject($orderProject = "DESC",
                                  $searchProject = null,
                                  $statusProject = null,
                                  $userId = null): array
    {
        $query = $this->createQueryBuilder('p');

        if ($searchProject != null) {
            $query
                ->leftJoin('p.productionTeam','pt')
                ->leftJoin('p.teamClient','tc')
                ->andWhere('p.nameProject Like :search or p.codeProject like :search
                 or pt.teamName like :search or tc.teamName like :search')
                ->setParameter('search', $searchProject)
            ;
        }

        if ($statusProject != null) {
            $query
                ->leftJoin('p.status','ps')
                ->andWhere('ps.id = :status')
                ->setParameter('status', $statusProject)
            ;
        }
        if ($userId != null) {
            $query
                ->leftJoin('p.productionTeam','pt')
                ->leftJoin('pt.teamMembers','pm')
                ->leftJoin('pt.teamLeader','pl')
                ->leftJoin('p.teamClient','tc')
                ->leftJoin('tc.teamMembers','cm')
                ->leftJoin('tc.teamLeader','cl')
                ->andWhere('pm.id = :user or pl.id = :user or cl.id = :user or cl.id = :user')
                ->setParameter('user', $userId)
            ;
        }

        $query->orderBy('p.startedAt', $orderProject);

        return $query->getQuery()->getResult();
    }

    /**
     * @return Project[] Returns an array of Project objects
     * @throws \Exception
     */
    public function findLastUpdatedProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.updatedAt < :date')
            ->setParameter('date', new \DateTime('now',new \DateTimeZone('Europe/Paris')))
            ->orderBy('p.startedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findByProdTeam($userId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.productionTeam','pt')
            ->leftJoin('pt.teamMembers','tm')
            ->leftJoin('pt.teamLeader','tl')
            ->andWhere('tm.id = :user or tl.id = :user')
            ->setParameter('user', $userId)
            ->orderBy('p.startedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findByTeamClient($userId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.teamClient','tc')
            ->leftJoin('tc.teamMembers','tm')
            ->leftJoin('tc.teamLeader','tl')
            ->andWhere('tm.id = :user or tl.id = :user')
            ->setParameter('user', $userId)
            ->orderBy('p.startedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;

    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findByStatus($statusId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.status','s')
            ->andWhere('s.id = :status')
            ->setParameter('status', $statusId)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findByBudget($budgetId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.projectBudget','b')
            ->andWhere('b.id = :budget')
            ->setParameter('budget', $budgetId)
            ->getQuery()
            ->getResult()
            ;
    }
}
