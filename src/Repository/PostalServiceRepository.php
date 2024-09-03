<?php

namespace App\Repository;

use App\Entity\PostalService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostalService>
 *
 * @method PostalService|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalService|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalService[]    findAll()
 * @method PostalService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalService::class);
    }

    //    /**
    //     * @return PostalService[] Returns an array of PostalService objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PostalService
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
