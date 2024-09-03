<?php

namespace App\Repository;

use App\Entity\PostalServiceRange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostalServiceRange>
 *
 * @method PostalServiceRange|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalServiceRange|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalServiceRange[]    findAll()
 * @method PostalServiceRange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalServiceRangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalServiceRange::class);
    }
    
    
//    /**
//     * @return PostalServiceRange[] Returns an array of PostalServiceRange objects
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

//    public function findOneBySomeField($value): ?PostalServiceRange
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
