<?php

namespace App\Repository;

use App\Entity\CategoryDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryDocument>
 *
 * @method CategoryDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryDocument[]    findAll()
 * @method CategoryDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryDocument::class);
    }

//    /**
//     * @return CategoryDocument[] Returns an array of CategoryDocument objects
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

//    public function findOneBySomeField($value): ?CategoryDocument
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
