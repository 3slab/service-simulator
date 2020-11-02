<?php

namespace App\Repository;

use App\Entity\PreconfigureResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PreconfigureResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreconfigureResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreconfigureResponse[]    findAll()
 * @method PreconfigureResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreconfigureResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreconfigureResponse::class);
    }

    // /**
    //  * @return PreconfigureResponse[] Returns an array of PreconfigureResponse objects
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
    public function findOneBySomeField($value): ?PreconfigureResponse
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
