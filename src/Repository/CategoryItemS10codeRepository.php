<?php

namespace App\Repository;

use App\Entity\CategoryItemS10code;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryItemS10code>
 *
 * @method CategoryItemS10code|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryItemS10code|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryItemS10code[]    findAll()
 * @method CategoryItemS10code[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryItemS10codeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryItemS10code::class);
    }

//    /**
//     * @return CategoryItemS10code[] Returns an array of CategoryItemS10code objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryItemS10code
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
