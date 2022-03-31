<?php

namespace App\Repository;

use App\Entity\Risk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Risk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Risk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Risk[]    findAll()
 * @method Risk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Risk::class);
    }

    /**
     * @return Risk[] Returns an array of Risk objects
     */
    public function findByProject($projectId):array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.project = :val')
            ->setParameter('val', $projectId)
            ->orderBy('r.identificationDateRisk', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
