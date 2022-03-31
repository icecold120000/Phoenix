<?php

namespace App\Repository;

use App\Entity\Fact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fact[]    findAll()
 * @method Fact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fact::class);
    }

    /**
     * @return Fact[] Returns an array of Fact objects
     */
    public function findByProject($projectId)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.project = :val')
            ->setParameter('val', $projectId)
            ->orderBy('f.dateFact', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Fact[] Returns an array of Fact objects
     */
    public function findAllVerified($validated = false): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.isValidated = :validate')
            ->setParameter('validate', $validated)
            ->orderBy('f.dateFact', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
