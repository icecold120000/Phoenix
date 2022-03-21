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
    public function findByProdTeam($productionId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.productionTeam','pt')
            ->leftJoin('pt.teamMembers','tm')
            ->andWhere('tm.id = :val')
            ->setParameter('val', $productionId)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findByTeamClient($clientId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.teamClient','tc')
            ->leftJoin('tc.teamMembers','tm')
            ->andWhere('tm.id = :val')
            ->setParameter('val', $clientId)
            ->orderBy('p.id', 'DESC')
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
            ->andWhere('s.id = :val')
            ->setParameter('val', $statusId)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
