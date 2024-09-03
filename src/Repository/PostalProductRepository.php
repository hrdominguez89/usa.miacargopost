<?php

namespace App\Repository;

use App\Entity\PostalProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostalProduct>
 *
 * @method PostalProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalProduct[]    findAll()
 * @method PostalProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalProduct::class);
    }

//    /**
//     * @return PostalProduct[] Returns an array of PostalProduct objects
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

//    public function findOneBySomeField($value): ?PostalProduct
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
