<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\PaginationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param Product $entity
     * @param bool $flush
     * @return void
     */
    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Product $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    ////////////////////
    ///
    /// OWN METHODS
    ///
    ////////////////////

    public function findAllPaginated($c, $o, $s, $l = 100, $p = 1): PaginationInterface {

        $dql = "SELECT e.id, e.appId, e.name, e.dateCreated FROM App\Entity\Product e ";

        if ($s['value']) {
            $dql = $dql." WHERE (LOWER(e.name) LIKE LOWER(:filter)) ";
        }

        /** @noinspection DuplicatedCode */
        $dql = $dql." ORDER BY e.".($c[$o[0]['column']]['data'].' '.$o[0]['dir']);

        $query = $this->getEntityManager()->createQuery($dql);

        if ($s['value']) {
            $query->setParameter('filter', '%'.$s['value'].'%');
        }

        return $this->paginator->paginate($query, $p, $l);
    }
}
